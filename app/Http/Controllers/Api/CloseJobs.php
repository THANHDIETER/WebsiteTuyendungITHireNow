<?php

namespace App\Http\Controllers\Api;

use App\Models\Job;
use App\Models\Setting;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class CloseJobs extends Controller
{
    public function index(Request $request)
    {
        
        if ($request->query('token') !== Setting::getValue('token_cron')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

       if ($request->boolean('check')) {
            $count = Job::where('status', 'published')
                ->where('created_at', '<=', now()->subMonth())
                ->count();

            return response()->json([
                'ok'    => true,
                'count' => $count,
                'time' => now()->toDateTimeString(),
            ]);
        }

        $affected = Job::where('status', 'published')
            ->where('created_at', '<=', now()->subMonth())
            ->update([
                'status'     => 'closed',
                'updated_at' => now(),
            ]);

        return response()->json([
            'ok'       => true,
            'affected' => $affected,
            'time'   => now()->toDateTimeString(),
        ]);
    }
}
