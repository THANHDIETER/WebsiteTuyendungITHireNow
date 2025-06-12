<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\CompanyPackageSubscription;

class SubscriptionController extends Controller
{
    public function index()
    {
        $companyId = Auth::user()->company_id;

        $subscriptions = CompanyPackageSubscription::with('employerPackage')
            ->where('company_id', $companyId)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('employer.subscriptions.index', compact('subscriptions'));
    }
    public function show($id)
{
    $subscription = CompanyPackageSubscription::with('employerPackage')
        ->where('company_id', Auth::user()->company_id)
        ->findOrFail($id);

    return view('employer.subscriptions.show', compact('subscription'));
}

public function renew($id)
{
    $subscription = CompanyPackageSubscription::findOrFail($id);

    // Logic: mở form chọn gói mới hoặc dùng lại gói cũ
    return redirect()->route('employer.packages.index')->with('info', 'Vui lòng chọn gói để gia hạn.');
}

}
