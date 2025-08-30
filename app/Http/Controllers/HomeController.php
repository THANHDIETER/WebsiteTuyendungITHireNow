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
        $title = 'Trang chủ';
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

        return view('website.index', compact('categories', 'latestJobs','title'));
    }

    public function jobsApi(Request $request)
    {
        $locationId = $request->input('location');
        $page = $request->get('page', 1);
        $perPage = 6;
        $featuredPerPage = 2;
        $otherPerPage = $perPage - $featuredPerPage;

        $allJobs = Job::with(['company', 'category', 'skills', 'location'])
            ->where('status', 'published')
            ->when($locationId, fn($q) => $q->where('location_id', $locationId))
            ->get();

        $featuredJobs = $allJobs->where('is_featured', true)->shuffle()->values();
        $otherJobs = $allJobs->where('is_featured', false)->shuffle()->values();

        // ✅ Lấy 2 featured theo "batch" sau khi đã shuffle
        $featuredPage = $featuredJobs
            ->slice(($page - 1) * $featuredPerPage, $featuredPerPage)
            ->values();

        // ✅ Lấy 4 job khác
        $otherPage = $otherJobs
            ->slice(($page - 1) * $otherPerPage, $otherPerPage)
            ->values();

        // ✅ Nếu thiếu featured, bù thêm job khác
        if ($featuredPage->count() < $featuredPerPage) {
            $need = $featuredPerPage - $featuredPage->count();
            $extraOther = $otherJobs
                ->slice(($page - 1) * $otherPerPage + $otherPerPage, $need)
                ->values();
            $otherPage = $otherPage->merge($extraOther);
        }

        // ✅ Ghép featured + other
        $pageJobs = $featuredPage->merge($otherPage)->values();

        // ✅ Thêm is_favorited
        if (auth()->check()) {
            $user = auth()->user();
            $favoritedIds = $user->favoriteJobs()->pluck('job_id')->toArray();

            $pageJobs = $pageJobs->map(function ($job) use ($favoritedIds) {
                $job->is_favorited = in_array($job->id, $favoritedIds);
                return $job;
            });
        } else {
            $pageJobs = $pageJobs->map(function ($job) {
                $job->is_favorited = false;
                return $job;
            });
        }

        // ✅ Tổng số trang
        $totalPages = max(
            ceil($featuredJobs->count() / $featuredPerPage),
            ceil($otherJobs->count() / $otherPerPage)
        );

        $paginated = new LengthAwarePaginator(
            $pageJobs,
            $allJobs->count(),
            $perPage,
            $page,
            ['path' => url('/api/jobs')]
        );

        return response()->json([
            'data' => $paginated->items(),
            'current_page' => $paginated->currentPage(),
            'last_page' => $totalPages,
            'per_page' => $paginated->perPage(),
            'total' => $paginated->total()
        ]);
    }
}
