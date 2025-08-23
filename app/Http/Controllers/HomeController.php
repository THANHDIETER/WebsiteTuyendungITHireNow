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
        $locationId = $request->input('location');
        $page = $request->get('page', 1);
        $perPage = 6; // số job mỗi trang
        $limit   = 50; // số lượng tối đa cho mỗi nhóm

        // ================================
        // 1 QUERY lấy tất cả jobs cần thiết
        // ================================
        $allJobs = Job::with(['company', 'category', 'skills'])
            ->where('status', 'published')
            ->when($locationId, fn($q) => $q->where('location_id', $locationId))
            ->get();

        // ================================
        // Chia nhóm jobs trong PHP
        // ================================
        $paidJobs      = $allJobs->where('is_paid', true)->shuffle()->take($limit);
        $featuredJobs  = $allJobs->where('is_featured', true)->shuffle()->take($limit);
        $topViewedJobs = $allJobs->sortByDesc('views')->shuffle()->take($limit);
        $latestJobsAll = $allJobs->sortByDesc('created_at')->shuffle()->take($limit);

        // ================================
        // Round-robin xen kẽ
        // ================================
        $finalJobs = collect();
        $max = max(
            $paidJobs->count(),
            $featuredJobs->count(),
            $topViewedJobs->count(),
            $latestJobsAll->count()
        );

        for ($i = 0; $i < $max; $i++) {
            if (isset($paidJobs[$i]))      $finalJobs->push($paidJobs[$i]);
            if (isset($featuredJobs[$i]))  $finalJobs->push($featuredJobs[$i]);
            if (isset($topViewedJobs[$i])) $finalJobs->push($topViewedJobs[$i]);
            if (isset($latestJobsAll[$i])) $finalJobs->push($latestJobsAll[$i]);
        }

        // Loại bỏ trùng lặp & reset index
        $finalJobs = $finalJobs->unique('id')->values();

        // ================================
        // Paginate thủ công
        // ================================
        $total = $finalJobs->count();
        $jobs = new LengthAwarePaginator(
            $finalJobs->forPage($page, $perPage),
            $total,
            $perPage,
            $page,
            ['path' => $request->url(), 'query' => $request->query()]
        );

        // ================================
        // Latest jobs (6 cái mới nhất) có cache
        // ================================
        $latestJobs = Cache::remember('latest_jobs', 600, function () {
            return Job::with(['company','category','skills'])
                ->where('status', 'published')
                ->orderByDesc('created_at')
                ->limit(6)
                ->get();
        });

        // ================================
        // Categories có cache
        // ================================
        $categories = Cache::remember('categories_active', 3600, function () {
            return Category::where('is_active', true)
                ->withCount([
                    'jobs as jobs_count' => fn($q) => $q->where('status', 'published')
                ])
                ->orderBy('sort_order')
                ->get();
        });

        return view('website.index', compact('jobs', 'categories', 'latestJobs'));
    }
}
