<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    public function index()
    {
        // Debug: Log the total number of jobs
        $totalJobs = Job::count();
        Log::info('Total jobs in database: ' . $totalJobs);

        // Get jobs with less restrictive conditions
        $jobs = Job::with(['company', 'category'])
            ->where(function($query) {
                $query->where('status', 'published')
                    ->orWhereNull('status');
            })
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get();

        // Debug: Log the number of jobs after filtering
        Log::info('Jobs after filtering: ' . $jobs->count());
        Log::info('Jobs data:', $jobs->toArray());

        $categories = Category::where('is_active', true)
            ->withCount('jobs')
            ->orderBy('sort_order')
            ->take(12)
            ->get();

        return view('website.index', compact('jobs', 'categories'));
    }
}
