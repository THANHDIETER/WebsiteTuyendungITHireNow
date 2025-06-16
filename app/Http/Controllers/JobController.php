<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use App\Models\Company;
use App\Models\Category;
use Illuminate\Http\Request;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $query = Job::with(['company', 'category', 'skills'])
            ->where('status', 'published')
            ->orderBy('created_at', 'desc');

        // Tìm kiếm theo từ khóa (title, description, requirements)
        if ($request->filled('keyword')) {
            $kw = $request->keyword;
            $query->where(function ($q) use ($kw) {
                $q->where('title', 'like', "%$kw%")
                    ->orWhere('description', 'like', "%$kw%")
                    ->orWhere('requirements', 'like', "%$kw%");
            });
        }

        // Địa điểm (radio)
       if ($request->filled('locations')) {
    $query->whereIn('location', (array) $request->input('locations'));
}



        // Ngành nghề (select)
        if ($request->filled('category_id')) {
            $query->where('category_id', $request->category_id);
        }

        // Công ty (select)
        if ($request->filled('company_id')) {
            $query->where('company_id', $request->company_id);
        }

        // Loại hình công việc (checkbox - nhiều lựa chọn)
        if ($request->filled('job_type')) {
            $jobTypes = $request->input('job_type');
            if (is_array($jobTypes)) {
                $query->whereIn('job_type', $jobTypes);
            } else {
                $query->where('job_type', $jobTypes);
            }
        }

        // Cấp bậc (select)
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // Kinh nghiệm (text hoặc select tuỳ web)
        if ($request->filled('experience')) {
            $query->where('experience', $request->experience);
        }

        // Lọc theo khoảng lương giao với job
        if ($request->filled('min_salary')) {
            $query->where('salary_max', '>=', $request->min_salary);
        }
        if ($request->filled('max_salary')) {
            $query->where('salary_min', '<=', $request->max_salary);
        }

        // Kỹ năng (checkbox nhiều)
        if ($request->filled('skills')) {
            $skills = $request->input('skills');
            $query->whereHas('skills', function ($q) use ($skills) {
                $q->whereIn('name', $skills);
            });
        }

        // Chỉ việc nổi bật (toggle)
        if ($request->filled('is_featured')) {
            $query->where('is_featured', 1);
        }

        // Phân trang kết quả
        $jobs = $query->paginate(9)->appends($request->except('page'));

        // Danh sách filter cho form (truyền đủ để UX tốt)
        $categories = Category::all();
        $companies  = Company::all();
        $skills     = Skill::all();

        // Tìm 3 việc làm nổi bật nhất cho phần gợi ý
        $topJobs = (clone $query)
            ->orderByDesc('is_featured')
            ->orderByDesc('salary_min')
            ->limit(3)
            ->get();

        // Truyền sang view đầy đủ
        return view('website.jobs.job', compact('jobs', 'categories', 'companies', 'skills', 'topJobs'));
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
