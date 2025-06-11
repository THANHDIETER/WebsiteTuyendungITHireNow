<?php

namespace App\Http\Controllers;

use App\Models\Job;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index()
    {
        $latestJobs = Job::with('company')
            ->where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->limit(6) // Lấy 6 công việc mới nhất
            ->get();

        return view('website.index', compact('latestJobs'));
    }
}
