<?php

namespace App\Http\Controllers\Api\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Payment;
use Illuminate\Support\Facades\Validator;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    /**
     * Lấy danh sách hóa đơn của người dùng đang đăng nhập
     */
    public function index(Request $request)
    {
        // $userId = $request->user()->id;
        $userId = 10;

        $payments = Payment::with('package')
            ->where('user_id', $userId)
            ->orderByDesc('created_at')
            ->get();

        return response()->json($payments);
    }

    /**
     * Xem chi tiết hóa đơn
     */
    public function show($id)
    {
        $payment = Payment::with('package')->findOrFail($id);
        return response()->json($payment);
    }

    public function downloadPdf($id)
    {
        try {
            // Lấy thông tin hóa đơn cùng gói và người dùng
            $payment = Payment::with(['package', 'user'])->findOrFail($id);

            // Sinh PDF từ view
            $pdf = Pdf::loadView('admin.payment.invoice', compact('payment'));

            // Tên file
            $filename = 'invoice_' . $payment->invoice_number . '.pdf';

            // Trả về file tải về với header đầy đủ
            return response($pdf->output(), 200)
                ->header('Content-Type', 'application/pdf')
                ->header('Content-Disposition', 'attachment; filename="' . $filename . '"');

        } catch (\Exception $e) {
            return response()->json(['error' => 'Không thể tạo file PDF'], 500);
        }
    }

}
