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

        return view('website.jobs.job-details', compact('job'));
    }
}
