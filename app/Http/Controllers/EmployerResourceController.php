<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Models\CompanyPackageSubscription;
use App\Models\EmployerPackageOrder;
use App\Models\EmployerPackageLog;
use App\Models\EmployerFreePosting;
use App\Models\EmployerPackageUsage;

class EmployerResourceController extends Controller
{
    public function index()
    {
        // hiển thị employer.blade.php làm trang chính
        return view('website.employers.employer');
    }

    public function subscriptions()
    {
        $subscriptions = CompanyPackageSubscription::with(['company','package'])->paginate(15);
        return view('website.employers.subscriptions', compact('subscriptions'));
    }

    public function orders()
    {
        $orders = EmployerPackageOrder::with(['company','package'])->paginate(15);
        return view('website.employers.orders', compact('orders'));
    }

    public function logs()
    {
        $logs = EmployerPackageLog::with(['order','job'])->paginate(15);
        return view('website.employers.logs', compact('logs'));
    }

    public function freePostings()
    {
        $frees = EmployerFreePosting::with('company')->paginate(15);
        return view('website.employers.free_postings', compact('frees'));
    }

    public function usages()
    {
        $usages = EmployerPackageUsage::with(['company','package'])->paginate(15);
        return view('website.employers.usages', compact('usages'));
    }
}