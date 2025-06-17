<?php

namespace App\Http\Controllers\Employers;

use App\Models\Payment;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Models\ServicePackage;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class PackageController extends Controller
{

    public function index()
    {
        $packages = ServicePackage::where('is_active', 1)
            ->orderBy('sort_order')
            ->get();

        $company = Auth::user()->company;
        $currentSubscription = $company?->activePackage();

        $payments = Payment::with('package')
            ->where('user_id', Auth::id())
            ->orderByDesc('created_at')
            ->get();


        return view('employer.packages.index', compact('packages', 'currentSubscription', 'payments'));
    }


    public function purchase($id)
    {
        $package = ServicePackage::find($id);
        $bankAccounts = BankAccount::where('is_active', 1)->get();

        return view('employer.packages.purchase', compact('package', 'bankAccounts'));

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
        $package = ServicePackage::findOrFail($packageId);
        $bankId = $request->input('bank');
        $bankAccount = BankAccount::findOrFail($bankId);

        $vatPercent = 10;
        $vatAmount = $package->price * ($vatPercent / 100);
        $totalAmount = $package->price + $vatAmount;

        $transactionId = strtoupper(uniqid($bankAccount->bank));

        // Lưu vào bảng payment
        $paymentId = Payment::create([
            'user_id' => auth::id(),
            'package_id' => $package->id,
            'amount' => $totalAmount,
            'currency' => 'VND',
            'vat_percent' => $vatPercent,
            'invoice_number' => 'INV-' . now()->format('Ymd') . '-' . rand(1000, 9999),
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