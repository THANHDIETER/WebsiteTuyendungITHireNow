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
    public function userStats(Request $request)
    {
        $query = User::query();

        // Lọc theo thời gian nếu có
        if ($request->filled('dateFrom') && $request->filled('dateTo')) {
            $dateFrom = Carbon::parse($request->dateFrom)->startOfDay();
            $dateTo = Carbon::parse($request->dateTo)->endOfDay();

            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        $roles = ['admin', 'employer', 'job_seeker'];

        $users = $query->whereIn('role', $roles)
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
    public function jobStats(Request $request)
    {
        $query = Job::query();

        // Lọc theo thời gian nếu có
        if ($request->filled('dateFrom') && $request->filled('dateTo')) {
            $dateFrom = Carbon::parse($request->dateFrom)->startOfDay();
            $dateTo = Carbon::parse($request->dateTo)->endOfDay();

            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        }

        $today = now()->startOfDay();

        $active = (clone $query)->whereDate('deadline', '>=', $today)->count();
        $closed = (clone $query)->whereDate('deadline', '<', $today)->count();

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
        $type = $request->input('type', 'monthly');

        $query = Application::query();

        // Lọc theo thời gian nếu có
        if ($request->filled('dateFrom') && $request->filled('dateTo')) {
            $dateFrom = Carbon::parse($request->dateFrom)->startOfDay();
            $dateTo = Carbon::parse($request->dateTo)->endOfDay();

            $query->whereBetween('created_at', [$dateFrom, $dateTo]);
        } else {
            // Mặc định lấy dữ liệu trong năm hiện tại
            $start = Carbon::now()->startOfYear();
            $end = Carbon::now()->endOfYear();
            $query->whereBetween('created_at', [$start, $end]);
        }

        $applications = $query
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