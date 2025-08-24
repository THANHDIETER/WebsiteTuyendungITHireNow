<?php

namespace App\Jobs;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\BankAccount;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Http;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;

class SyncBankJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function handle()
    {
        $accounts = BankAccount::where('is_active', true)->get();
        $results = [];

        foreach ($accounts as $account) {
            $token         = $account->token;
            $password      = $account->password;
            $accountNumber = $account->account_number;
            $bankAccountId = $account->id;

            $bank = strtolower($account->bank);
            $url = match ($bank) {
                'momo'   => "https://api.web2m.com/historyapimomo/{$token}",
                'acb'    => "https://api.web2m.com/historyapiacbv3/{$password}/{$accountNumber}/{$token}",
                'mbbank' => "https://api.web2m.com/historyapimbnotiv3/{$password}/{$accountNumber}/{$token}",
                default  => null
            };

            if (!$url) {
                $results[] = "Ngân hàng không hỗ trợ: {$account->bank}";
                continue;
            }

            $response = Http::timeout(10)->get($url); // set timeout để tránh treo quá lâu

            if (!$response->successful()) {
                $results[] = "API {$account->bank} lỗi: {$response->status()}";
                continue;
            }

            $data = $response->json();

            $transactions = match ($bank) {
                'momo'        => $data['momoMsg']['tranList'] ?? [],
                'acb', 'mbbank' => $data['transactions'] ?? [],
                default       => []
            };

            if (empty($transactions)) {
                $results[] = "Không có giao dịch: {$account->bank} - {$account->account_number}";
                continue;
            }

            // Lấy tất cả trans_id đã có sẵn 1 lần
            $existingTrans = BankLog::where('bank_account_id', $bankAccountId)
                ->pluck('trans_id')
                ->toArray();

            $insertData = [];
            foreach ($transactions as $item) {
                $transId = $item['tranId'] ?? $item['transactionID'] ?? $item['id'] ?? null;
                if (!$transId || in_array((string)$transId, $existingTrans)) {
                    continue;
                }

                try {
                    $transTime = null;
                    if ($bank === 'momo' && isset($item['clientTime'])) {
                        $transTime = Carbon::createFromTimestampMs($item['clientTime']);
                    } elseif (($bank === 'acb' || $bank === 'mbbank') && isset($item['transactionDate'])) {
                        $transTime = Carbon::createFromFormat('d/m/Y', $item['transactionDate']);
                    }

                    $description = $item['comment'] ?? $item['description'] ?? 'Không có mô tả';
                    $partner     = $item['partnerName'] ?? '';
                    if ($partner) {
                        $description .= ' - ' . $partner;
                    }

                    $type = null;
                    if ($bank === 'momo') {
                        $type = ($item['io'] ?? 0) == 1 ? 'credit' : 'debit';
                    } else {
                        $type = strtolower($item['type'] ?? '');
                    }

                    $insertData[] = [
                        'bank_account_id' => $bankAccountId,
                        'trans_id'        => (string)$transId,
                        'amount'          => $item['amount'] ?? 0,
                        'trans_time'      => $transTime,
                        'type'            => $type,
                        'description'     => $description,
                        'created_at'      => now(),
                        'updated_at'      => now(),
                    ];

                } catch (\Exception $e) {
                    $results[] = "Lỗi xử lý {$transId}: " . $e->getMessage();
                }
            }

            // Insert 1 lần
            if (!empty($insertData)) {
                BankLog::insert($insertData);
                $results[] = "✅ {$account->bank} - {$account->account_number}: thêm " . count($insertData) . " giao dịch mới.";
            } else {
                $results[] = "✅ {$account->bank} - {$account->account_number}: không có giao dịch mới.";
            }
        }

        Log::info('Bank sync results:', $results);
    }
}
