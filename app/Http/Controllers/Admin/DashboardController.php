<?php

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Support\Carbon;

class AdminDashboardController extends Controller
{
    public function index()
    {
        // Phân loại user theo role
        $userStats = [
            'seeker' => User::where('role', 'seeker')->count(),
            'employer' => User::where('role', 'employer')->count(),
            'admin' => User::where('role', 'admin')->count(),
        ];

        // Jobs
        $jobStats = [
            'open' => Job::where('status', 'open')->count(),
            'closed' => Job::where('status', 'closed')->count(),
        ];

        // Lượt ứng tuyển theo tuần
        $applicationsWeekly = Application::selectRaw('WEEK(created_at) as week, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('week')
            ->orderBy('week')
            ->get();

        // Lượt ứng tuyển theo tháng
        $applicationsMonthly = Application::selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', now()->year)
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        return view('admin.dashboard', compact(
            'userStats', 'jobStats', 'applicationsWeekly', 'applicationsMonthly'
        ));
    }
}
