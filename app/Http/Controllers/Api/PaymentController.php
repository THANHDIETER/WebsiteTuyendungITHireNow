<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\Payment;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
   public function handlePending(Request $request)
    {
        // Bảo vệ bằng token nếu cần
        if ($request->query('token') !== config('app.payment_check_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $now = now();
        $stats = [
            'paid' => 0,
            'failed_amount_mismatch' => 0,
            'failed_content_mismatch' => 0,
            'expired' => 0,
            'pending_no_match' => 0,
        ];

        $pendingPayments = Payment::where('status', 'pending')
            ->orderBy('created_at')
            ->limit(100)
            ->get();

        foreach ($pendingPayments as $payment) {
            $transactionId = $payment->transaction_id;

            // Trùng cả số tiền & nội dung => paid
            $matchedLog = BankLog::where('amount', $payment->amount)
                ->where('description', 'like', '%' . $transactionId . '%')
                ->first();

            if ($matchedLog) {
                $payment->status = 'paid';
                $payment->paid_at = Carbon::parse($matchedLog->trans_time ?? $now);
                $payment->save();
                $stats['paid']++;
                continue;
            }

            // Trùng nội dung nhưng sai số tiền => failed
            $wrongAmountLog = BankLog::where('description', 'like', '%' . $transactionId . '%')
                ->where('amount', '<>', $payment->amount)
                ->first();

            if ($wrongAmountLog) {
                $payment->status = 'failed';
                $payment->paid_at = $now;
                $payment->save();
                $stats['failed_amount_mismatch']++;
                continue;
            }

            // Trùng số tiền nhưng sai nội dung => failed
            $wrongContentLog = BankLog::where('amount', $payment->amount)
                ->where('description', 'not like', '%' . $transactionId . '%')
                ->first();

            if ($wrongContentLog) {
                $payment->status = 'failed';
                $payment->paid_at = $now;
                $payment->save();
                $stats['failed_content_mismatch']++;
                continue;
            }

            // Hết hạn => expired
            if ($payment->created_at <= $now->copy()->subMinutes(60)) {
                $payment->status = 'expired';
                $payment->paid_at = $now;
                $payment->save();
                $stats['expired']++;
            } else {
                $stats['pending_no_match']++;
            }
        }

        return response()->json([
            'message' => 'Đã xử lý tối đa 100 đơn pending',
            'thống_kê' => $stats,
        ]);
    }
}
