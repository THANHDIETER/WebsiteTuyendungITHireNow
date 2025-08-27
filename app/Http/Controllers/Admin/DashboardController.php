<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Job;
use App\Models\JobApplication;
use App\Models\EmployerPackageOrder;
use App\Models\Payment;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $now = Carbon::now();
        $startOfMonth = $now->copy()->startOfMonth();

        // ======= Người dùng =======
        $usersByRole = User::select('role', DB::raw('COUNT(*) as total'))
            ->groupBy('role')
            ->pluck('total', 'role');

        $newUsersByRole = User::select('role', DB::raw('COUNT(*) as total'))
            ->where('created_at', '>=', $startOfMonth)
            ->groupBy('role')
            ->pluck('total', 'role');

        $totalUsers = $usersByRole->sum();
        $newUsersThisMonth = $newUsersByRole->sum();

        // ======= Việc làm =======
        $jobStatus = Job::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusMap = [
            'published' => 'Đã đăng',
            'closed' => 'Đã đóng',
            'pending' => 'Đang chờ duyệt',
            'rejected' => 'Từ chối'
        ];

        // đổi key sang tiếng Việt
        $jobStatus = $jobStatus->mapWithKeys(function ($count, $key) use ($statusMap) {
            return [$statusMap[$key] ?? ucfirst($key) => $count];
        });
        $totalJobs = $jobStatus->sum();

        $jobsByCategory = DB::table('job_category')
            ->join('jobs', 'job_category.job_id', '=', 'jobs.id')
            ->join('categories', 'job_category.category_id', '=', 'categories.id')
            ->select('categories.name as category', DB::raw('COUNT(jobs.id) as total'))
            ->groupBy('categories.name')
            ->get();

        $skills = DB::table('job_skill')
            ->join('skills', 'job_skill.skill_id', '=', 'skills.id')
            ->select('skills.skill_name as skill', DB::raw('COUNT(job_skill.id) as total'))
            ->groupBy('skills.skill_name')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // ======= Đơn ứng tuyển =======
        $applicationsByStatus = JobApplication::select('status', DB::raw('COUNT(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalApplications = $applicationsByStatus->sum();

        $applicationsThisMonth = JobApplication::where('created_at', '>=', $startOfMonth)->count();

        // ánh xạ tiếng Việt
        $statusMap = [
            'pending' => 'Đang chờ',
            'interview_scheduled' => 'Mời phỏng vấn',
            'offered' => 'Trúng tuyển',
            'no_response' => 'Không phản hồi'
        ];

        $applicationsByStatus = $applicationsByStatus->mapWithKeys(function ($count, $key) use ($statusMap) {
            return [$statusMap[$key] ?? ucfirst($key) => $count];
        });

        // ======= Đơn hàng =======
        $ordersByMonth = EmployerPackageOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(id) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $totalOrders = $ordersByMonth->sum('total');

        // ======= Doanh thu =======
        $revenueByMonth = Payment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $totalRevenue = $revenueByMonth->sum('total');

        return view('admin.index', compact(
            'totalUsers',
            'usersByRole',
            'newUsersByRole',
            'newUsersThisMonth',
            'totalJobs',
            'jobStatus',
            'jobsByCategory',
            'skills',
            'totalApplications',
            'applicationsThisMonth',
            'applicationsByStatus',
            'totalOrders',
            'ordersByMonth',
            'totalRevenue',
            'revenueByMonth'
        ));
    }

    public function indexv2(Request $request)
    {
        // ---- Lọc theo ngày ----
        $filter = $request->input('filter', 'this_month'); // mặc định: tháng này

        $now = Carbon::now();
        $startDate = $now->copy()->startOfMonth();
        $endDate = $now->copy()->endOfMonth();

        switch ($filter) {
            case 'last_month':
                $startDate = $now->copy()->subMonth()->startOfMonth();
                $endDate = $now->copy()->subMonth()->endOfMonth();
                break;
            case 'this_year':
                $startDate = $now->copy()->startOfYear();
                $endDate = $now->copy()->endOfYear();
                break;
            case 'custom':
                $startDate = $request->input('start_date') ? Carbon::parse($request->input('start_date')) : $startDate;
                $endDate = $request->input('end_date') ? Carbon::parse($request->input('end_date')) : $endDate;
                break;
            default:
                break;
        }

        // ======= Người dùng =======
        $usersByRole = User::select('role', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('role')
            ->pluck('total', 'role');

        $totalUsers = $usersByRole->sum();

        // ======= Việc làm =======
        $jobStatus = Job::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->pluck('total', 'status');

        $statusMapJob = [
            'published' => 'Đã đăng',
            'closed' => 'Đã đóng',
            'pending' => 'Đang chờ duyệt',
            'rejected' => 'Từ chối'
        ];

        $jobStatus = $jobStatus->mapWithKeys(function ($count, $key) use ($statusMapJob) {
            return [$statusMapJob[$key] ?? ucfirst($key) => $count];
        });
        $totalJobs = $jobStatus->sum();

        $jobsByCategory = DB::table('job_category')
            ->join('jobs', 'job_category.job_id', '=', 'jobs.id')
            ->join('categories', 'job_category.category_id', '=', 'categories.id')
            ->select('categories.name as category', DB::raw('COUNT(jobs.id) as total'))
            ->whereBetween('jobs.created_at', [$startDate, $endDate])
            ->groupBy('categories.name')
            ->get();

        $skills = DB::table('job_skill')
            ->join('skills', 'job_skill.skill_id', '=', 'skills.id')
            ->select('skills.skill_name as skill', DB::raw('COUNT(job_skill.id) as total'))
            ->whereBetween('job_skill.created_at', [$startDate, $endDate])
            ->groupBy('skills.skill_name')
            ->orderByDesc('total')
            ->limit(7)
            ->get();

        // ======= Đơn ứng tuyển =======
        $applicationsByStatus = JobApplication::select('status', DB::raw('COUNT(*) as total'))
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('status')
            ->pluck('total', 'status');

        $totalApplications = $applicationsByStatus->sum();

        $statusMapApp = [
            'pending' => 'Đang chờ',
            'interview_scheduled' => 'Mời phỏng vấn',
            'offered' => 'Trúng tuyển',
            'no_response' => 'Không phản hồi'
        ];

        $applicationsByStatus = $applicationsByStatus->mapWithKeys(function ($count, $key) use ($statusMapApp) {
            return [$statusMapApp[$key] ?? ucfirst($key) => $count];
        });

        // ======= Đơn hàng =======
        $ordersByMonth = EmployerPackageOrder::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('COUNT(id) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $totalOrders = $ordersByMonth->sum('total');

        // ======= Doanh thu =======
        $revenueByMonth = Payment::select(
            DB::raw('MONTH(created_at) as month'),
            DB::raw('SUM(amount) as total')
        )
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month')
            ->get();

        $totalRevenue = $revenueByMonth->sum('total');

        // ---- Trả về AJAX ----
        if ($request->ajax()) {
            $html = view('admin.partials.dashboard_data_v2', compact(
                'filter',
                'startDate',
                'endDate',
                'totalUsers',
                'usersByRole',
                'totalJobs',
                'jobStatus',
                'jobsByCategory',
                'skills',
                'totalApplications',
                'applicationsByStatus',
                'totalOrders',
                'ordersByMonth',
                'totalRevenue',
                'revenueByMonth'
            ))->render();

            return response()->json([
                'html' => $html,
                'data' => [
                    'jobStatus' => $jobStatus,
                    'jobsByCategory' => $jobsByCategory,
                    'skills' => $skills,
                    'applicationsByStatus' => $applicationsByStatus
                ]
            ]);
        }

        return view('admin.indexv2', compact(
            'filter',
            'startDate',
            'endDate',
            'totalUsers',
            'usersByRole',
            'totalJobs',
            'jobStatus',
            'jobsByCategory',
            'skills',
            'totalApplications',
            'applicationsByStatus',
            'totalOrders',
            'ordersByMonth',
            'totalRevenue',
            'revenueByMonth'
        ));
    }

}
