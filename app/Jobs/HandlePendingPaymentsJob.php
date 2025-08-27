<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\Payment;
use App\Models\Setting;
use App\Models\EmployerPackageLog;
use App\Models\EmployerPackageOrder;
use App\Models\EmployerPackageUsage;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class HandlePendingPaymentsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
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
            ->limit(50) // có thể tăng lên nếu muốn
            ->get();

        foreach ($pendingPayments as $payment) {
            $transactionId = $payment->transaction_id;
            $normalizedTarget = strtoupper(preg_replace('/\s+/', '', $transactionId));

            $timeFrom = $payment->created_at->copy()->subDay();
            $timeTo = $payment->created_at->copy()->addDay();

            $logs = BankLog::where('amount', $payment->amount)
                ->whereBetween('trans_time', [$timeFrom, $timeTo])
                ->where('is_used', false)
                ->get();

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

                    $matchedLog->update([
                        'is_used' => true,
                        'matched_payment_id' => $payment->id
                    ]);

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

                        $orders = EmployerPackageUsage::create([
                            'company_id' => $company->id,
                            'employer_package_id' => $package->id,
                            'post_limit' => $package->post_limit,
                            'posts_used' => 0,
                            'start_date' => $startDate,
                            'end_date' => $endDate,
                            'is_active' => true,
                            'created_at' => now(),
                            'updated_at' => now(),
                        ]);

                        EmployerPackageLog::create([
                            'order_id' => $orders->id,
                            'job_id' => null,
                            'used_at' => now(),
                            'action' => 'Mua gói thành công',
                        ]);

                        Log::info("Đã tạo order ID {$orders->id} cho công ty ID {$company->id}");
                    }
                    continue;
                }

                // Sai số tiền
                $wrongAmountLog = BankLog::where('description', 'like', '%' . $transactionId . '%')
                    ->where('amount', '<>', $payment->amount)
                    ->whereBetween('trans_time', [$timeFrom, $timeTo])
                    ->where('is_used', false)
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

                // Sai nội dung
                $wrongContentLog = $logs->first(function ($log) use ($normalizedTarget) {
                    $normalizedDesc = strtoupper(preg_replace('/\s+/', '', $log->description));
                    return !Str::contains($normalizedDesc, $normalizedTarget);
                });

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
                $timeoutMinutes = (int) Setting::getValue('payment_timeout_minutes', 6);
                if ($payment->created_at <= $now->copy()->subMinutes($timeoutMinutes)) {
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
                }
            } catch (\Exception $e) {
                Log::error("Lỗi khi xử lý payment_id={$payment->id}: " . $e->getMessage());
            }
        }

        Log::info("Kết quả xử lý pending payments:", $stats);
    }
}
