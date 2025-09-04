<?php

namespace App\Services;

use App\Models\Payment;
use App\Models\EmployerPackageLog;
use App\Models\EmployerPackageOrder;
use App\Models\EmployerPackageUsage;
use Illuminate\Support\Facades\Log;

class PaymentService
{
    public static function activatePackage(Payment $payment)
    {
        $package = $payment->package;
        $user = $payment->user;
        $company = $payment->company ?? optional($user)->company;

        if (!$package || !$company) {
            Log::warning("Không tìm thấy package hoặc công ty cho payment ID {$payment->id}");
            return;
        }

        $startDate = $payment->paid_at;
        $endDate = $startDate->copy()->addDays($package->duration_days);

        $order = EmployerPackageOrder::create([
            'payment_id' => $payment->id,
            'company_id' => $company->id,
            'employer_package_id' => $package->id,
            'post_limit' => $package->post_limit,
            'post_used' => 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'status' => 'active',
        ]);

        $usage = EmployerPackageUsage::create([
            'company_id' => $company->id,
            'employer_package_id' => $package->id,
            'post_limit' => $package->post_limit,
            'posts_used' => 0,
            'start_date' => $startDate,
            'end_date' => $endDate,
            'is_active' => true,
        ]);

        EmployerPackageLog::create([
            'order_id' => $order->id,
            'job_id' => null,
            'used_at' => now(),
            'action' => 'Mua gói thành công',
        ]);

        Log::info("Đã kích hoạt gói cho công ty ID {$company->id}, payment ID {$payment->id}");
    }
}
