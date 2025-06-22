<?php

namespace App\Http\Controllers\Employers;

use App\Models\Payment;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    /**
     * Hiển thị chi tiết thanh toán.
     */
    public function show($id)
    {
        $payment = Payment::find($id);

        if (!$payment) {
            return redirect()->route('employer.packages.index')
                ->with('error', 'Hóa đơn không tồn tại.');
        }

        if ($payment->status !== 'pending') {
            return redirect()->route('employer.packages.index')
                ->with('error', 'Thanh toán không hợp lệ hoặc đã được xử lý.');
        }

        $bankAccount = BankAccount::where('bank', $payment->payment_gateway)->first();

        return view('employer.payment.show', compact('payment', 'bankAccount'));
    }


    public function checkStatus(Payment $payment)
    {
        return response()->json([
            'status' => $payment->status,
        ]);
    }
    public function cancel(Payment $payment)
    {
        if ($payment->status !== 'pending') {
            return back()->with('error', 'Không thể hủy đơn đã xử lý.');
        }

        $payment->update(['status' => 'canceled']);
        return back()->with('success', 'Đã hủy đơn thành công.');
    }


}
