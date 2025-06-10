<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;

class DashboardController extends Controller 
{
    /**
     * Trang dashboard tổng quan cho admin (hiển thị Blade view)
     */
    public function index()
    {
        return view('admin.index');
    }

    /**
     * API: Thống kê số lượng user theo vai trò
     */
    public function userStats()
    {
        $data = [
            'admin' => User::where('role', 'admin')->count(),
            'employer' => User::where('role', 'employer')->count(),
            'seeker' => User::where('role', 'job_seeker')->count(),
        ];

        return response()->json($data);
    }

    /**
     * API: Thống kê job theo trạng thái
     */
 
    public function jobStats()
{
    $today = now()->toDateString();

    $data = [
        'active' => Job::whereDate('deadline', '>=', $today)->count(),
        'closed' => Job::whereDate('deadline', '<', $today)->count(),
    ];

    return response()->json($data);
}


    /**
     * API: Thống kê lượt ứng tuyển theo tuần hoặc tháng
     */
    public function applicationStats(Request $request)
    {
        $type = $request->input('type', 'weekly');

        $query = Application::query();

        if ($type === 'weekly') {
            $query->selectRaw('WEEK(created_at) as period, COUNT(*) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('period');
        } else {
            $query->selectRaw('MONTH(created_at) as period, COUNT(*) as total')
                ->whereYear('created_at', now()->year)
                ->groupBy('period');
        }

        return response()->json($query->orderBy('period')->get());
    }
}
