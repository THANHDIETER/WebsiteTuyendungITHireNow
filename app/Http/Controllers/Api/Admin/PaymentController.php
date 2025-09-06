<?php

namespace App\Http\Controllers\Api\Admin;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\Payment;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use App\Services\PaymentService;
use App\Models\EmployerPackageLog;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;

class PaymentController extends Controller
{
    /**
     * Lấy danh sách hóa đơn của người dùng đang đăng nhập
     */
    public function index(Request $request)
    {
        $perPage = $request->input('per_page', 10);
        $status = $request->input('status');

        $query = Payment::with('package', 'user')->orderByDesc('created_at');

        if ($status) {
            $query->where('status', $status);
        }

        return response()->json($query->paginate($perPage));
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

    public function approve($id)
    {
        $payment = Payment::with('package', 'user')->findOrFail($id);

        if ($payment->status !== 'pending') {
            return response()->json(['error' => 'Chỉ duyệt được đơn pending'], 400);
        }

        $payment->status = 'paid';
        $payment->paid_at = now();
        $payment->save();

        PaymentService::activatePackage($payment);

        return response()->json(['message' => 'Duyệt thành công', 'payment' => $payment]);
    }

    public function reject($id)
    {
        $payment = Payment::with('package', 'user')->findOrFail($id);

        if ($payment->status !== 'pending') {
            return response()->json(['error' => 'Chỉ từ chối được đơn pending'], 400);
        }

        $payment->status = 'failed';
        $payment->paid_at = now();
        $payment->save();

        EmployerPackageLog::create([
            'order_id' => $payment->id,
            'job_id' => null,
            'used_at' => now(),
            'action' => 'Thanh toán bị từ chối thủ công',
        ]);

        return response()->json(['message' => 'Đã từ chối đơn thanh toán', 'payment' => $payment]);
    }

}
