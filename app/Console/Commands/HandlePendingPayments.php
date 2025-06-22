<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Payment;
use App\Models\BankLog;
use Carbon\Carbon;

class HandlePendingPayments extends Command
{
    protected $signature = 'payments:handle-pending';
    protected $description = 'Cập nhật các đơn thanh toán chờ xử lý: đánh dấu đã thanh toán nếu có log hoặc hết hạn sau 60 phút';

    public function handle()
    {
        $pendingPayments = Payment::where('status', 'pending')->get();
        $now = Carbon::now();
        $countPaid = 0;
        $countExpired = 0;

        foreach ($pendingPayments as $payment) {
            // Kiểm tra xem có bản ghi trong bank_logs không
            $matchedLog = BankLog::where('amount', $payment->amount)
                ->where('description', 'like', '%' . $payment->transaction_id . '%')
                ->first();

            if ($matchedLog) {
                $payment->status = 'paid';
                $payment->paid_at = Carbon::parse($matchedLog->trans_time ?? $now);
                $payment->save();
                $this->info("✅ Đơn #{$payment->id} đã thanh toán.");
                $countPaid++;
                continue;
            }

            // Kiểm tra quá hạn 60 phút
            if ($payment->created_at <= $now->copy()->subMinutes(60)) {
                $payment->status = 'expired';
                $payment->paid_at = $now;
                $payment->save();
                $this->warn("⛔ Đơn #{$payment->id} đã hết hạn.");
                $countExpired++;
            }
        }

        $this->line("🎉 Đã cập nhật: {$countPaid} thanh toán thành công, {$countExpired} đơn hết hạn.");
    }
}
