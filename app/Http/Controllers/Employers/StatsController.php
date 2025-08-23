<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use App\Models\Job;
use App\Models\JobApplication;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;

class StatsController extends Controller
{
    private function currentCompanyId(): int
    {
        $user = auth()->user();
        if (!empty($user->company_id)) {
            return (int) $user->company_id;
        }
        $company = Company::where('user_id', $user->id)->first();
        if ($company)
            return (int) $company->id;
        abort(403, 'Không tìm thấy công ty tương ứng với tài khoản này.');
    }

    /** Dashboard tĩnh 30 ngày gần nhất */
    public function index()
    {
        $title = 'Thống kê v1';
        $companyId = $this->currentCompanyId();

        $jobsTotal = Job::where('company_id', $companyId)->count();
        $jobsActive = Job::where('company_id', $companyId)
            ->when($this->hasColumn(Job::class, 'status'), fn($q) => $q->where('status', 'active'))
            ->count();
        $appsTotal = JobApplication::whereHas('job', fn($q) => $q->where('company_id', $companyId))->count();
        $avgAppPerJob = $jobsTotal > 0 ? round($appsTotal / $jobsTotal, 2) : 0;

        $topJobsByApps = Job::where('company_id', $companyId)
            ->withCount('applications')
            ->orderByDesc('applications_count')
            ->limit(5)
            ->get(['id', 'title']);

        [$from, $to, $chartNote] = $this->smartWindowLast30Days($companyId);

        $series = $this->mergedSeries($companyId, $from, $to);

        return view('employer.index', compact(
            'jobsTotal',
            'jobsActive',
            'appsTotal',
            'avgAppPerJob',
            'topJobsByApps',
            'series',
            'chartNote',
            'title'
        ));
    }

    /** View lọc dữ liệu */
    public function filter()
    {
        $title = 'Thống kê v2';
        $defaultFrom = now()->subDays(29)->toDateString();
        $defaultTo = now()->toDateString();
        return view('employer.filter', compact('defaultFrom', 'defaultTo', 'title'));
    }

    /** API JSON trả dữ liệu lọc */
    public function filterData(Request $request)
    {
        $request->validate([
            'from' => 'required|date',
            'to' => 'required|date|after_or_equal:from',
        ]);

        $companyId = $this->currentCompanyId();
        $from = Carbon::parse($request->input('from'))->startOfDay();
        $to = Carbon::parse($request->input('to'))->endOfDay();

        $jobs = Job::where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->count();

        $applications = JobApplication::join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->where('jobs.company_id', $companyId)
            ->whereBetween(DB::raw('COALESCE(job_applications.applied_at, job_applications.created_at)'), [$from, $to])
            ->count();

        $avgAppPerJob = $jobs > 0 ? round($applications / $jobs, 2) : 0;

        $topJobsByApps = Job::where('company_id', $companyId)
            ->whereHas('applications', function ($q) use ($from, $to) {
                $q->whereBetween(DB::raw('COALESCE(job_applications.applied_at, job_applications.created_at)'), [$from, $to]);
            })
            ->withCount([
                'applications as applications_count' => function ($q) use ($from, $to) {
                    $q->whereBetween(DB::raw('COALESCE(job_applications.applied_at, job_applications.created_at)'), [$from, $to]);
                }
            ])
            ->orderByDesc('applications_count')
            ->limit(5)
            ->get(['id', 'title']);

        $series = $this->mergedSeries($companyId, $from, $to);

        return response()->json(compact(
            'jobs',
            'applications',
            'avgAppPerJob',
            'topJobsByApps',
            'series'
        ));
    }

    /** ============= Helpers ============= */

    /** Lấy khung 30 ngày cuối cùng có hoạt động */
    private function smartWindowLast30Days(int $companyId): array
    {
        $lastJob = Job::where('company_id', $companyId)->max('created_at');
        $lastApp = JobApplication::join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->where('jobs.company_id', $companyId)
            ->max(DB::raw('COALESCE(job_applications.applied_at, job_applications.created_at)'));

        $last = null;
        if ($lastJob)
            $last = Carbon::parse($lastJob);
        if ($lastApp)
            $last = $last ? max($last, Carbon::parse($lastApp)) : Carbon::parse($lastApp);

        $to = $last ? $last->copy()->endOfDay() : now()->endOfDay();
        $from = (clone $to)->subDays(29)->startOfDay();

        $chartNote = $last && $to->lt(now()->subDay())
            ? 'Hiển thị 30 ngày quanh mốc hoạt động gần nhất: ' . $to->format('Y-m-d')
            : null;

        return [$from, $to, $chartNote];
    }

    /** Khởi tạo nhãn ngày */
    private function emptySeries(Carbon $from, Carbon $to): array
    {
        $labels = [];
        $data = [];
        $cursor = $from->clone();
        while ($cursor->lte($to)) {
            $labels[] = $cursor->format('Y-m-d');
            $data[] = 0;
            $cursor->addDay();
        }
        return [$labels, $data];
    }

    /** Gộp jobs + applications chung nhãn */
    private function mergedSeries(int $companyId, Carbon $from, Carbon $to): array
    {
        [$labels, $jobsData] = $this->emptySeries($from, $to);
        [$labels2, $appsData] = $this->emptySeries($from, $to);

        // Jobs
        $jobRows = Job::selectRaw('DATE(created_at) as d, COUNT(*) as c')
            ->where('company_id', $companyId)
            ->whereBetween('created_at', [$from, $to])
            ->groupBy('d')
            ->pluck('c', 'd');
        foreach ($jobRows as $date => $count) {
            if (($i = array_search($date, $labels)) !== false)
                $jobsData[$i] = (int) $count;
        }

        // Applications
        $appRows = JobApplication::join('jobs', 'jobs.id', '=', 'job_applications.job_id')
            ->where('jobs.company_id', $companyId)
            ->selectRaw('DATE(COALESCE(job_applications.applied_at, job_applications.created_at)) as d, COUNT(*) as c')
            ->whereBetween(DB::raw('COALESCE(job_applications.applied_at, job_applications.created_at)'), [$from, $to])
            ->groupBy('d')
            ->pluck('c', 'd');
        foreach ($appRows as $date => $count) {
            if (($i = array_search($date, $labels)) !== false)
                $appsData[$i] = (int) $count;
        }

        return [
            'jobs' => ['labels' => $labels, 'data' => $jobsData],
            'apps' => ['labels' => $labels, 'data' => $appsData],
        ];
    }

    private function hasColumn(string $modelClass, string $column): bool
    {
        try {
            $m = new $modelClass;
            $table = $m->getTable();
            $cols = $m->getConnection()->getSchemaBuilder()->getColumnListing($table);
            return in_array($column, $cols, true);
        } catch (\Throwable $e) {
            return false;
        }
    }
}
