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

            // Việc có trả phí (ưu tiên hiển thị đầu tiên)
            $paidJobs = (clone $baseQuery)
                ->where('is_paid', true)
                ->inRandomOrder()
                ->take(2)
                ->get();

            // Top lượt xem, tránh trùng với paidJobs
            $topViewed = (clone $baseQuery)
                ->whereNotIn('id', $paidJobs->pluck('id'))
                ->orderByDesc('views')
                ->take(2)
                ->get();

            // Random hot khác, tránh trùng với paidJobs + topViewed
            $randomHot = (clone $baseQuery)
                ->whereNotIn('id', $paidJobs->pluck('id')->merge($topViewed->pluck('id')))
                ->inRandomOrder()
                ->take(2)
                ->get();

            // Gộp theo thứ tự: paidJobs -> topViewed -> randomHot
            $featuredJobs = $paidJobs
                ->merge($topViewed)
                ->merge($randomHot)
                ->unique('id');
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
