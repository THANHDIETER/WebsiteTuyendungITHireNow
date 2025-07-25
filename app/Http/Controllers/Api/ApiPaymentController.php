<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\Payment;
use App\Models\Setting;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Models\EmployerPackageLog;
use Illuminate\Support\Facades\Log;
use App\Http\Controllers\Controller;
use App\Models\EmployerPackageOrder;
use App\Models\EmployerPackageUsage;

class ApiPaymentController extends Controller
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

                        $company->increment('free_post_quota', $package->post_limit);

                        EmployerPackageLog::create([
                            'order_id' => $order->id,
                            'job_id' => null,
                            'used_at' => now(),
                            'action' => 'Mua gói thành công',
                        ]);

                        EmployerPackageUsage::create([
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

                        Log::info("Đã tạo order ID {$order->id} cho công ty ID {$company->id}");
                    } else {
                        Log::warning("Thiếu package hoặc company khi xử lý đơn paid: payment_id={$payment->id}");
                    }

                    continue;
                }

                // Trùng nội dung nhưng sai số tiền
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

                // Trùng số tiền nhưng sai nội dung
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

        return response(
            json_encode([
                'message' => 'Đã xử lý tối đa 100 đơn pending',
                'thống_kê' => $stats,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            200,
            ['Content-Type' => 'text/plain']
        );
    }


}