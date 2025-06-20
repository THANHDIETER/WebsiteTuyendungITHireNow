<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\Payment;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use App\Models\EmployerPackageLog;
use App\Http\Controllers\Controller;
use App\Models\EmployerPackageOrder;

class PaymentController extends Controller
{
    public function handlePending(Request $request)
    {
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
            $normalizedTarget = strtoupper(preg_replace('/\s+/', '', $transactionId));
            $logs = BankLog::where('amount', $payment->amount)->get();

            $matchedLog = $logs->first(function ($log) use ($normalizedTarget) {
                $normalizedDesc = strtoupper(preg_replace('/\s+/', '', $log->description));
                return Str::contains($normalizedDesc, $normalizedTarget);
            });

            $package = $payment->package;
            $user = $payment->user;
            $company = $payment->company ?? optional($user)->company;

            try {
                if ($matchedLog) {
                    $payment->status = 'paid';
                    $payment->paid_at = Carbon::parse($matchedLog->trans_time ?? $now);
                    $payment->save();
                    $stats['paid']++;

                    if ($package && $company) {
                        $startDate = $payment->paid_at;
                        $endDate = $startDate->copy()->addDays($package->duration_days);

                        $order = EmployerPackageOrder::create([
                            'company_id' => $company->id,
                            'employer_package_id' => $package->id,
                            'post_limit' => $package->post_limit,
                            'post_used' => 0,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'status' => 'active',
                        ]);

                        EmployerPackageLog::create([
                            'order_id' => $order->id,
                            'job_id' => null,
                            'used_at' => now(),
                            'action' => 'Mua gói thành công',
                        ]);

                        Log::info("Đã tạo order ID {$order->id} cho công ty ID {$company->id}");
                    } else {
                        Log::warning("Thiếu package hoặc company khi xử lý đơn paid: payment_id={$payment->id}");
                    }

                    continue;
                }

                // Trùng nội dung nhưng sai số tiền
                $wrongAmountLog = BankLog::where('description', 'like', '%' . $transactionId . '%')
                    ->where('amount', '<>', $payment->amount)
                    ->first();

                if ($wrongAmountLog) {
                    $payment->status = 'failed';
                    $payment->paid_at = $now;
                    $payment->save();
                    $stats['failed_amount_mismatch']++;

                    if ($package && $company) {
                        EmployerPackageLog::create([
                            'order_id' => null,
                            'job_id' => null,
                            'used_at' => now(),
                            'action' => 'Thanh toán thất bại: sai số tiền',
                        ]);
                    }

                    continue;
                }

                // Trùng số tiền nhưng sai nội dung
                $wrongContentLog = BankLog::where('amount', $payment->amount)
                    ->get()
                    ->filter(function ($log) use ($normalizedTarget) {
                        $normalizedDesc = strtoupper(preg_replace('/\s+/', '', $log->description));
                        return !Str::contains($normalizedDesc, $normalizedTarget);
                    })->first();

                if ($wrongContentLog) {
                    $payment->status = 'failed';
                    $payment->paid_at = $now;
                    $payment->save();
                    $stats['failed_content_mismatch']++;

                    if ($package && $company) {
                        EmployerPackageLog::create([
                            'order_id' => null,
                            'job_id' => null,
                            'used_at' => now(),
                            'action' => 'Thanh toán thất bại: sai nội dung',
                        ]);
                    }

                    continue;
                }

                // Hết hạn
                if ($payment->created_at <= $now->copy()->subMinutes(60)) {
                    $payment->status = 'expired';
                    $payment->paid_at = $now;
                    $payment->save();
                    $stats['expired']++;

                    EmployerPackageLog::create([
                        'order_id' => null,
                        'job_id' => null,
                        'used_at' => now(),
                        'action' => 'Đơn thanh toán hết hạn',
                    ]);
                } else {
                    $stats['pending_no_match']++;

                    EmployerPackageLog::create([
                        'order_id' => null,
                        'job_id' => null,
                        'used_at' => now(),
                        'action' => 'Không tìm thấy giao dịch khớp',
                    ]);
                }
            } catch (\Exception $e) {
                Log::error("Lỗi khi xử lý payment_id={$payment->id}: " . $e->getMessage());
            }
        }

        return response()->json([
            'message' => 'Đã xử lý tối đa 100 đơn pending',
            'thống_kê' => $stats,
        ]);
    }

}
