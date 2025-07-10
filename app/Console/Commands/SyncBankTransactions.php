<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\BankAccount;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class SyncBankTransactions extends Command
{
    protected $signature = 'bank:sync';
    protected $description = 'Sync bank transactions from Web2M API';

    public function handle()
    {
        $accounts = BankAccount::all();

        if ($accounts->isEmpty()) {
            $this->warn('Không có tài khoản ngân hàng nào để xử lý.');
            return;
        }

        foreach ($accounts as $account) {
            $token = $account->token;
            $password = $account->password;
            $accountNumber = $account->account_number;
            $bankAccountId = $account->id;

            $bank = strtolower($account->bank);
            $url = match ($bank) {
                'momo' => "https://api.web2m.com/historyapimomo/{$token}",
                'acb' => "https://api.web2m.com/historyapiacbv3/{$password}/{$accountNumber}/{$token}",
                'mbbank' => "https://api.web2m.com/historyapimbnotiv3/{$password}/{$accountNumber}/{$token}",
                default => null
            };

            if (!$url) {
                $this->warn("Ngân hàng không hỗ trợ: {$account->bank}");
                continue;
            }

            $response = Http::get($url);

            if (!$response->successful()) {
                $this->error("API {$account->bank} lỗi: {$response->status()}");
                continue;
            }

            $data = $response->json();

            $transactions = match ($bank) {
                'momo' => $data['momoMsg']['tranList'] ?? [],
                'acb', 'mbbank' => $data['transactions'] ?? [],
                default => []
            };

            if (empty($transactions)) {
                $this->warn("Không tìm thấy giao dịch từ API {$bank}.");
                continue;
            }

            foreach ($transactions as $item) {
                // Lấy ID giao dịch theo loại ngân hàng
                $transId = $item['tranId'] ?? $item['transactionID'] ?? $item['id'] ?? null;
                if (!$transId) {
                    continue;
                }

                // Check trùng trước khi insert
                $exists = BankLog::where('bank_account_id', $bankAccountId)
                                 ->where('trans_id', $transId)
                                 ->exists();
                if ($exists) {
                    continue;
                }

                try {
                    // Xử lý thời gian
                    $transTime = null;
                    if ($bank === 'momo' && isset($item['clientTime'])) {
                        $transTime = Carbon::createFromTimestampMs($item['clientTime']);
                    } elseif (($bank === 'acb' || $bank === 'mbbank') && isset($item['transactionDate'])) {
                        $transTime = Carbon::createFromFormat('d/m/Y', $item['transactionDate']);
                    }

                    // Xử lý mô tả
                    $description = $item['comment'] ?? $item['description'] ?? 'Không có mô tả';
                    $partner = $item['partnerName'] ?? '';
                    if ($partner) {
                        $description .= ' - ' . $partner;
                    }

                    // Xác định loại giao dịch
                    $type = null;
                    if ($bank === 'momo') {
                        $type = ($item['io'] ?? 0) == 1 ? 'credit' : 'debit';
                    } elseif ($bank === 'acb' || $bank === 'mbbank') {
                        $type = strtolower($item['type'] ?? null);
                    }

                    BankLog::create([
                        'bank_account_id' => $bankAccountId,
                        'trans_id' => (string) $transId,
                        'amount' => $item['amount'] ?? 0,
                        'trans_time' => $transTime,
                        'type' => $type,
                        'description' => $description,
                    ]);
                } catch (\Exception $e) {
                    $this->error("Lỗi lưu giao dịch {$transId}: " . $e->getMessage());
                }
            }

            $this->info("Đã xử lý xong tài khoản {$account->bank} ({$account->account_number})");
        }

        $this->info('✅ Đồng bộ giao dịch hoàn tất.');
    }
}
