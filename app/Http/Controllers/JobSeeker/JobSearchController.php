<?php

namespace App\Http\Controllers\JobSeeker;

use App\Models\Job;
use App\Models\Company;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class JobSearchController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::query()
            ->with(['company', 'skills', 'category'])
            ->where('status', 'published')
            ->where('is_approved', 1);

        // Tìm kiếm từ khóa
        if ($request->filled('keyword')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', "%{$request->keyword}%")
                  ->orWhere('description', 'like', "%{$request->keyword}%")
                  ->orWhere('requirements', 'like', "%{$request->keyword}%");
            });
        }

        // Bộ lọc theo các trường thực có trong CSDL
        if ($request->filled('location')) {
            $query->where('location', $request->location);
        }

        if ($request->filled('job_type')) {
            $query->where('job_type', $request->job_type);
        }

        if ($request->filled('min_salary')) {
            $query->where('salary_min', '>=', $request->min_salary);
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('experience')) {
            $query->where('experience', $request->experience);
        }

        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        if ($request->filled('skills')) {
            $query->whereHas('skills', function ($q) use ($request) {
                $q->whereIn('name', $request->skills);
            });
        }

        $jobs = $query->latest()->paginate(10);

        return view('website.jobs.job', [
            'jobs' => $jobs,
            'categories' => Category::all(),
            'skills' => Skill::all(),
            'companies' => Company::all(),
        ]);
    }
}