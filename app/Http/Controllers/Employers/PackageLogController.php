<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\EmployerPackageLog;

class PackageLogController extends Controller
{
    public function index()
    {
        $employerId = Auth::id();

        $logs = EmployerPackageLog::with(['order.company', 'job.company'])
            ->whereHas('order.company', function ($q) use ($employerId) {
                $q->where('user_id', $employerId);
            })
            ->orWhereHas('job.company', function ($q) use ($employerId) {
                $q->where('user_id', $employerId);
            })
            ->latest()
            ->get();

        return view('employer.package_logs.index', compact('logs'));
    }
}
