<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Carbon\Carbon;

class FeaturedController extends Controller
{
    public function handlePending(Request $request)
    {
        // Bảo mật bằng token
        if ($request->query('token') !== Setting::getValue('token_cron')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        $now = Carbon::now();
        $updatedCount = 0;

        // Duyệt theo từng nhóm 100 job để tránh load tất cả vào RAM
        Job::where('is_featured', true)
            ->with(['packageUsage.package'])
            ->chunk(100, function ($jobs) use (&$updatedCount, $now) {
                foreach ($jobs as $job) {
                    $highlightDays = $job->packageUsage->package->highlight_days ?? 0;

                    if ($highlightDays > 0) {
                        $expiredAt = $job->created_at->addDays($highlightDays);
                        if ($now->greaterThan($expiredAt)) {
                            $job->update(['is_featured' => false]);
                            $updatedCount++;
                        }
                    }
                }
            });

        return response()->json([
            'message' => 'Cron check is_featured completed',
            'jobs_updated' => $updatedCount,
        ]);
    }
}
