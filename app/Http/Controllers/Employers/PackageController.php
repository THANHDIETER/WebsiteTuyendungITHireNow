<?php

namespace App\Http\Controllers\Employers;

use App\Models\Payment;
use App\Models\Setting;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\EmployerPackage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{

    public function index()
    {
        // Lấy tất cả gói đang hoạt động (is_active = 1), sắp xếp giảm dần theo độ ưu tiên
        $packages = EmployerPackage::where('is_active', 1)
            ->orderByDesc('sort_order')
            ->get();

        // Lấy thông tin công ty của người dùng hiện tại
        $company = Auth::user()->company;
        if(!$company) {
            return redirect()->route('employer')->with('error', 'Bạn cần tạo công ty trước khi mua gói.');
        }

        // Lấy gói hiện tại đang sử dụng từ quan hệ Company
        $currentSubscription = $company?->activePackage();

        // Lấy tất cả các đơn thanh toán gói của user hiện tại
        $payments = Payment::with('package')
            ->where('user_id', Auth::id())
            ->orderByDesc('id')
            ->get();

        // Truyền dữ liệu ra view
        return view('employer.packages.index', compact(
            'packages',
            'currentSubscription',
            'payments'
        ));
    }



    public function purchase($id)
    {
        $package = EmployerPackage::find($id);
        $bankAccounts = BankAccount::where('is_active', 1)->get();
        $vat = (float) Setting::getValue('vat_rate', 0);
        $vatAmount = round($package->price * ($vat / 100));
        $totalWithVat = $package->price + $vatAmount;
        return view('employer.packages.purchase', compact('package', 'bankAccounts', 'vat', 'vatAmount', 'totalWithVat'));

    }

    public function history()
    {
        $user = auth::user();

        $payments = Payment::with('package')
            ->where('user_id', $user->id)
            ->orderByDesc('created_at')
            ->get();

        return view('employer.packages.history', compact('payments'));
    }




    public function subscribe(Request $request, $packageId)
    {
        $package = EmployerPackage::findOrFail($packageId);
        $bankId = $request->input('bank');
        $bankAccount = BankAccount::findOrFail($bankId);

        $vatPercent = (float) Setting::getValue('vat_rate', 0);
        $vatAmount = $package->price * ($vatPercent / 100);
        $totalAmount = $package->price + $vatAmount;

        $transactionId = Setting::generateTransactionId();

        $paymentId = Payment::create([
            'user_id' => auth::id(),
            'package_id' => $package->id,
            'amount' => $totalAmount,
            'currency' => 'VND',
            'vat_percent' => $vatPercent,
            'invoice_number' => 'INV-' . now()->format('Ymd-His') . '-' . rand(1000, 9999),
            'payment_method' => $bankAccount->bank,
            'payment_gateway' => $bankAccount->bank,
            'transaction_id' => $transactionId,
            'status' => 'pending',
        ]);

        return redirect()->route('employer.payment.show', $paymentId);
    }

    public function cancel($id)
    {
        $payment = Payment::where('id', $id)
            ->where('user_id', auth::id())
            ->where('status', 'pending')
            ->firstOrFail();

        $payment->status = 'canceled';
        $payment->save();

        return redirect()->route('employer.packages.history')->with('success', 'Đã hủy đơn thành công.');
    }

    public function show($id)
    {
        $payment = Payment::with('package')
            ->where('id', $id)
            ->where('user_id', auth::id())
            ->firstOrFail();

        return view('employer.packages.payment_detail', compact('payment'));
    }





}