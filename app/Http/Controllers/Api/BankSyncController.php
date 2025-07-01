<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use App\Models\BankLog;
use Illuminate\Support\Facades\Http;
use Carbon\Carbon;

class BankSyncController extends Controller
{
    public function sync(Request $request)
    {
         if ($request->query('token') !== config('app.payment_check_token')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $accounts = BankAccount::where('is_active', true)->get();
        $results = [];

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
                $results[] = "Ngân hàng không hỗ trợ: {$account->bank}";
                continue;
            }

            $response = Http::get($url);

            if (!$response->successful()) {
                $results[] = "API {$account->bank} lỗi: {$response->status()}";
                continue;
            }

            $data = $response->json();

            $transactions = match ($bank) {
                'momo' => $data['momoMsg']['tranList'] ?? [],
                'acb', 'mbbank' => $data['transactions'] ?? [],
                default => []
            };

            foreach ($transactions as $item) {
                $transId = $item['tranId'] ?? $item['transactionID'] ?? $item['id'] ?? null;
                if (!$transId) continue;

                if (BankLog::where('bank_account_id', $bankAccountId)->where('trans_id', $transId)->exists()) {
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
                    $partner = $item['partnerName'] ?? '';
                    if ($partner) {
                        $description .= ' - ' . $partner;
                    }

                    $type = null;
                    if ($bank === 'momo') {
                        $type = ($item['io'] ?? 0) == 1 ? 'credit' : 'debit';
                    } else {
                        $type = strtolower($item['type'] ?? '');
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
                    $results[] = "Lỗi lưu {$transId}: " . $e->getMessage();
                }
            }

            $results[] = "✅ Đã xử lý: {$account->bank} - {$account->account_number}";
        }

<<<<<<< HEAD
        return response()->json([
            'message' => 'Đã đồng bộ xong',
            'log' => $results,
        ]);
=======
        return response(json_encode([
                 'message' => 'Đã đồng bộ xong',
                 'log' => $results,
        ],JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE),
            200,
            ['Content-Type' => 'text/plain']

        );
      
>>>>>>> e40cc0bc24c6a785a04dee9082e12ea467e2fbbd
    }
}
