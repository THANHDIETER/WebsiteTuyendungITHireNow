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

        // Việc làm nổi bật (chỉ trang đầu tiên)
        $featuredJobs = collect();
        if ($page == 1) {
            $featuredJobs = Job::with(['company', 'category'])
                ->where(function ($query) {
                    $query->where('status', 'published')
                        ->orWhereNull('status');
                })
                ->when($locationId, fn ($q) => $q->where('location_id', $locationId))
                ->where('is_featured', true)
                ->inRandomOrder()
                ->take(2)
                ->get();
        }

        // Việc làm gần đây
        $jobs = Job::with(['company', 'category', 'skills']) // thêm skills
            ->where(function ($query) {
                $query->where('status', 'published')
                    ->orWhereNull('status');
            })
            ->when($locationId, fn ($q) => $q->where('location_id', $locationId))
            ->orderByDesc('created_at') // thay vì views, ưu tiên mới nhất
            ->paginate(6);

        // Danh mục ngành nghề
        $categories = Category::where('is_active', true)
            ->withCount('jobs')
            ->orderBy('sort_order')
            ->get(); // không nên paginate danh mục

        return view('website.index', compact('jobs', 'categories', 'featuredJobs'));
    }
}
