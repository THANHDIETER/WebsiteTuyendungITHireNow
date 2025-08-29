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
use App\Jobs\HandlePendingPaymentsJob;

class ApiPaymentController extends Controller
{
    public function handlePending(Request $request)
    {
        if ($request->query('token') !== Setting::getValue('token_cron')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Đẩy job vào queue thay vì xử lý trực tiếp
        // HandlePendingPaymentsJob::dispatch();

        return response(
            "Đã đưa vào hàng đợi xử lý payments pending. Vui lòng kiểm tra log.",
            200
        )->header('Content-Type', 'text/plain');

    }


}