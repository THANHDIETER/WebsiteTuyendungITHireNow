<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        $locationId = $request->input('location');
        $page = $request->get('page', 1);

        $featuredJobs = collect();

        if ($page == 1) {
            $baseQuery = Job::with(['company', 'category'])
                ->where('status', 'published')
                ->when($locationId, fn ($q) => $q->where('location_id', $locationId));

            // Top lượt xem
            $topViewed = (clone $baseQuery)
                ->orderByDesc('views')
                ->take(2)
                ->get();

            // Việc có trả phí, tránh trùng với topViewed
            $paidJobs = (clone $baseQuery)
                ->where('is_paid', true)
                ->whereNotIn('id', $topViewed->pluck('id'))
                ->inRandomOrder()
                ->take(2)
                ->get();

            // Random hot khác, tránh trùng với topViewed + paidJobs
            $randomHot = (clone $baseQuery)
                ->whereNotIn('id', $topViewed->pluck('id')->merge($paidJobs->pluck('id')))
                ->inRandomOrder()
                ->take(2)
                ->get();

            // Gộp tất cả lại, giới hạn 4 job nổi bật
            $featuredJobs = $topViewed
                ->merge($paidJobs)
                ->merge($randomHot)
                ->unique('id')
                ->take(4);
        }

        // Việc làm gần đây
        $jobs = Job::with(['company', 'category', 'skills'])
            ->where(function ($query) {
                $query->where('status', 'published')
                      ->orWhereNull('status');
            })
            ->when($locationId, fn ($q) => $q->where('location_id', $locationId))
            ->orderByDesc('created_at')
            ->paginate(6);

        // Ngành nghề
        $categories = Category::where('is_active', true)
            ->withCount('jobs')
            ->orderBy('sort_order')
            ->get();

        return view('website.index', compact('jobs', 'categories', 'featuredJobs'));
    }
}
