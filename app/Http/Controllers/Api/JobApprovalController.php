<?php

namespace App\Http\Controllers\Api;

use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Jobs\ProcessPendingJobs; // job mới

class JobApprovalController extends Controller
{
    public function sync(Request $request)
    {
        if ($request->query('token') !== Setting::getValue('token_cron')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        // Đưa toàn bộ xử lý vào queue
        ProcessPendingJobs::dispatch();

        return response()->json([
            'message' => 'Đã đưa vào hàng đợi xử lý tin tuyển dụng. Vui lòng kiểm tra log sau.'
        ]);
    }
}
