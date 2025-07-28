<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\Application;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

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
     * API: Thống kê số lượng user theo vai trò (admin, employer, seeker)
     */
    public function userStats()
    {
        $roles = ['admin', 'employer', 'job_seeker'];

        $users = User::whereIn('role', $roles)
            ->selectRaw('role, COUNT(*) as total')
            ->groupBy('role')
            ->pluck('total', 'role');

        return response()->json([
            'admin' => $users->get('admin', 0),
            'employer' => $users->get('employer', 0),
            'seeker' => $users->get('job_seeker', 0),
        ]);
    }

    /**
     * API: Thống kê job theo trạng thái (active hoặc closed dựa vào deadline)
     */
    public function jobStats()
    {
        $today = now()->startOfDay();

        $active = Job::whereDate('deadline', '>=', $today)->count();
        $closed = Job::whereDate('deadline', '<', $today)->count();

        return response()->json([
            'active' => $active,
            'closed' => $closed,
        ]);
    }


    /**
     * API: Thống kê lượt ứng tuyển theo tuần hoặc tháng
     */
    public function applicationStats(Request $request)
    {
        $type = $request->input('type', 'weekly');

        $start = Carbon::now()->startOfYear();
        $end = Carbon::now()->endOfYear();

        $applications = Application::query()
            ->whereBetween('created_at', [$start, $end])
            ->when($type === 'weekly', function ($query) {
                return $query->selectRaw('WEEK(created_at, 1) as period, COUNT(*) as total')
                    ->groupBy('period');
            }, function ($query) {
                return $query->selectRaw('MONTH(created_at) as period, COUNT(*) as total')
                    ->groupBy('period');
            })
            ->orderBy('period')
            ->get();

        return response()->json($applications);
    }
}
