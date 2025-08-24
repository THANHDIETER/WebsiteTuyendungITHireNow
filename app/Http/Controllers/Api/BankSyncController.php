<?php

namespace App\Http\Controllers\Api;

use Carbon\Carbon;
use App\Models\BankLog;
use App\Models\Setting;
use App\Jobs\SyncBankJob;
use App\Models\BankAccount;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Bus;
use App\Jobs\HandlePendingPaymentsJob;

class BankSyncController extends Controller
{
    public function sync(Request $request)
    {
        if ($request->query('token') !== Setting::getValue('token_cron')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Chạy SyncBankJob trước, khi xong thì chạy HandlePendingPaymentsJob
        Bus::chain([
            new SyncBankJob(),
            new HandlePendingPaymentsJob(),
        ])->dispatch();

        return response()->json([
            'message' => 'Đã đưa vào hàng đợi xử lý (BankSync + HandlePendingPayments).'
        ]);
    }
}
