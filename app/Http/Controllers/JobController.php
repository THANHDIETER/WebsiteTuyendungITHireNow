<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index()
    {
        $jobs = Job::with('company')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(9);

        return view('website.jobs.job', compact('jobs'));
    }

    public function show($slug)
    {
        $job = Job::with('company')
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Lấy các công việc liên quan cùng category
        $relatedJobs = Job::with('company')
            ->where('category_id', $job->category_id)
            ->where('id', '!=', $job->id)
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->take(4)
            ->get();

        return view('website.jobs.job-details', compact('job', 'relatedJobs'));
    }
}
