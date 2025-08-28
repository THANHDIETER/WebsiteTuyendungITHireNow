<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Cache;

class HomeController extends Controller
{
    public function index(Request $request)
    {

        $latestJobs = Cache::remember('latest_jobs', 600, function () {
            return Job::with(['company', 'category', 'skills'])
                ->where('status', 'published')
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        });

        $categories = Cache::remember('categories_active', 3600, function () {
            return Category::where('is_active', true)
                ->withCount([
                    'jobs as jobs_count' => fn($q) => $q->where('status', 'published')
                ])
                ->orderBy('sort_order')
                ->get();
        });

        return view('website.index', compact('categories', 'latestJobs'));
    }

    public function jobsApi(Request $request)
    {
        $locationId = $request->input('location');
        $page = $request->get('page', 1);
        $perPage = 6;
        $limit = 50;

        $allJobs = Job::with(['company', 'category', 'skills', 'location'])
            ->where('status', 'published')
            ->when($locationId, fn($q) => $q->where('location_id', $locationId))
            ->get();

        $paidJobs = $allJobs->where('is_paid', true)->shuffle()->take($limit);
        $featuredJobs = $allJobs->where('is_featured', true)->shuffle()->take($limit);
        $topViewedJobs = $allJobs->sortByDesc('views')->shuffle()->take($limit);
        $latestJobsAll = $allJobs->sortByDesc('created_at')->shuffle()->take($limit);

        $finalJobs = collect();
        $max = max(
            $paidJobs->count(),
            $featuredJobs->count(),
            $topViewedJobs->count(),
            $latestJobsAll->count()
        );

        for ($i = 0; $i < $max; $i++) {
            if (isset($paidJobs[$i])) {
                $finalJobs->push($paidJobs[$i]);
            }
            if (isset($featuredJobs[$i])) {
                $finalJobs->push($featuredJobs[$i]);
            }
            if (isset($topViewedJobs[$i])) {
                $finalJobs->push($topViewedJobs[$i]);
            }
            if (isset($latestJobsAll[$i])) {
                $finalJobs->push($latestJobsAll[$i]);
            }
        }

        // Unique + reset key để tránh lỗi null khi paginate
        $finalJobs = $finalJobs->unique('id')->values();

        // ✅ Thêm is_favorited dựa trên user login
        if (auth()->check()) {
            $user = auth()->user();
            $favoritedIds = $user->favoriteJobs()->pluck('job_id')->toArray();

            $finalJobs = $finalJobs->map(function ($job) use ($favoritedIds) {
                $job->is_favorited = in_array($job->id, $favoritedIds);
                return $job;
            });
        } else {
            $finalJobs = $finalJobs->map(function ($job) {
                $job->is_favorited = false;
                return $job;
            });
        }

        $total = $finalJobs->count();
        $paginated = new LengthAwarePaginator(
            $finalJobs->forPage($page, $perPage)->values(),
            $total,
            $perPage,
            $page,
            ['path' => url('/api/jobs')]
        );

        return response()->json([
            'data' => $paginated->items(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $paginated->lastPage(),
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total()
        ]);
    }
}
