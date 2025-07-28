<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use App\Models\Company;
use App\Models\Category;
use App\Models\Location;
use App\Models\JobType;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {

        $query = Job::with(['company', 'skills', 'jobType', 'location'])
            ->where('status', 'published');

        // Từ khóa
        if ($request->filled('q')) {
            $query->where(function ($q) use ($request) {
                $q->where('title', 'like', '%' . $request->q . '%')
                    ->orWhere('description', 'like', '%' . $request->q . '%');
            });

        }

        // Địa điểm
        if ($request->filled('location_id')) {
            $query->where('location_id', $request->location_id);
        }

        // Ngành nghề
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Công ty
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Loại công việc
        if ($request->filled('job_type_id')) {
            $query->where('job_type_id', $request->job_type_id);
        }

        // Cấp bậc
        if ($request->filled('level')) {
            $query->where('level_id', $request->level);
        }

        // Kinh nghiệm
        if ($request->filled('experience')) {
            $query->where('experience_id', $request->experience);
        }

        // Khoảng lương
        if ($request->filled('min_salary')) {
            $query->where('salary_max', '>=', $request->min_salary);
        }

        if ($request->filled('max_salary')) {
            $query->where('salary_min', '<=', $request->max_salary);
        }

        // Kỹ năng
        if ($request->filled('skills')) {
            $skills = $request->input('skills');
            $query->whereHas('skills', function ($q) use ($skills) {
                $q->whereIn('name', $skills);
            });
        }

        // Việc làm nổi bật
        if ($request->filled('is_featured')) {
            $query->where('is_featured', 1);
        }

        // Lấy danh sách việc làm
        $jobs = Job::with('company')
            ->where('status', 'published')
            ->orderByDesc('is_featured')
            ->orderByDesc('views')
            ->paginate(9);

        // Dữ liệu lọc cho form
        $categories = Category::all();
        $companies = Company::all();
        $skills = Skill::all();
        $locations = Location::all();
        $jobTypes = JobType::all();

        // Việc làm nổi bật gợi ý
        $topJobs = (clone $query)
            ->orderByDesc('is_featured')
            ->orderByDesc('salary_min')
            ->limit(3)
            ->get();

        return view('website.jobs.job', compact(
            'jobs',
            'categories',
            'companies',
            'skills',
            'locations',
            'jobTypes',
            'topJobs'
        ));
    }

    public function show($slug)
    {
        $job = Job::with([
            'company',
            'skills',
            'jobType',
            'location',
            'categories',
            'level',
            'experience',
            'language',
            'remotePolicy',
        ])
            ->where('slug', $slug)
            ->where('status', 'published')
            ->firstOrFail();

        // Lấy các công việc liên quan cùng danh mục (nếu có)
        $relatedJobs = collect();

        if ($job->categories->isNotEmpty()) {
            $relatedJobs = Job::with(['company'])
                ->where('id', '!=', $job->id)
                ->where('status', 'published')
                ->whereHas('categories', function ($query) use ($job) {
                    $query->whereIn('category_id', $job->categories->pluck('id'));
                })
                ->latest()
                ->take(6) // bạn có thể điều chỉnh số lượng
                ->get();
        }

        return view('website.jobs.job-details', compact('job', 'relatedJobs'));
    }

}
