<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Skill;
use App\Models\Company;
use App\Models\Category;
use App\Models\Location;
use App\Models\JobType;
use App\Models\Level;
use App\Models\JobExperience;
use App\Models\JobLanguage;
use Illuminate\Http\Request;

class JobController extends Controller
{
    /**
     * Trang danh sách việc làm mặc định (không lọc nâng cao)
     */
    public function index(Request $request)
    {
        // Lấy danh sách job mới nhất (không filter nâng cao)
        $jobs = Job::with(['company', 'skills', 'jobType', 'location', 'level', 'experience', 'language'])
            ->where('status', 'published')
            ->orderByDesc('created_at')
            ->paginate(9);

        // Các dữ liệu filter cho form
        $categories  = Category::all();
        $companies   = Company::all();
        $skills      = Skill::all();
        $locations   = Location::all();
        $jobTypes    = JobType::all();
        $levels      = Level::all();
        $experiences = JobExperience::all();
        $languages   = JobLanguage::all();

        // Gợi ý top jobs nổi bật
        $topJobs = Job::where('is_featured', 1)
            ->orderByDesc('salary_min')
            ->limit(3)
            ->get();

        return view('website.jobs.job', compact(
            'jobs', 'categories', 'companies', 'skills', 'locations',
            'jobTypes', 'levels', 'experiences', 'languages', 'topJobs'
        ));
    }

    /**
     * Trang search việc làm (lọc nâng cao)
     */
    public function search(Request $request)
    {
        $query = $this->buildSearchQuery($request);

        $jobs = $query->paginate(9)->appends($request->except('page'));

        // Dữ liệu filter cho form
        $categories  = Category::all();
        $companies   = Company::all();
        $skills      = Skill::all();
        $locations   = Location::all();
        $jobTypes    = JobType::all();
        $levels      = Level::all();
        $experiences = JobExperience::all();
        $languages   = JobLanguage::all();

        // Gợi ý top jobs nổi bật theo query filter
        $topJobs = (clone $query)
            ->orderByDesc('is_featured')
            ->orderByDesc('salary_min')
            ->limit(3)
            ->get();

        return view('website.jobs.job', compact(
            'jobs', 'categories', 'companies', 'skills', 'locations',
            'jobTypes', 'levels', 'experiences', 'languages', 'topJobs'
        ));
    }

    /**
     * Hàm build query search dùng chung cho cả index và search
     */
    private function buildSearchQuery(Request $request)
    {
        $query = Job::with(['company', 'skills', 'jobType', 'location', 'level', 'experience', 'language'])
            ->where('status', 'published');

        // Từ khóa
        if ($request->filled('q')) {
            $q = $request->q;
            $query->where(function ($sub) use ($q) {
                $sub->where('title', 'like', "%$q%")
                    ->orWhere('description', 'like', "%$q%")
                    ->orWhere('requirements', 'like', "%$q%")
                    ->orWhere('benefits', 'like', "%$q%")
                    ->orWhere('meta_title', 'like', "%$q%")
                    ->orWhere('meta_description', 'like', "%$q%")
                    ->orWhere('keyword', 'like', "%$q%");
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
        if ($request->filled('level_id')) {
            $query->where('level_id', $request->level_id);
        }

        // Kinh nghiệm
        if ($request->filled('experience_id')) {
            $query->where('experience_id', $request->experience_id);
        }

        // Ngôn ngữ
        if ($request->filled('language_id')) {
            $query->where('language_id', $request->language_id);
        }

        // Hình thức remote
        if ($request->filled('remote_policy_id')) {
            $query->where('remote_policy_id', $request->remote_policy_id);
        }

        // Lọc lương
        if ($request->filled('min_salary')) {
            $query->where('salary_max', '>=', $request->min_salary);
        }
        if ($request->filled('max_salary')) {
            $query->where('salary_min', '<=', $request->max_salary);
        }

        // Kỹ năng
        if ($request->filled('skills')) {
            $skills = $request->input('skills');
            if (is_string($skills)) {
                $skills = explode(',', $skills);
            }
            $query->whereHas('skills', function ($q) use ($skills) {
                $q->whereIn('skills.id', $skills);
            });
        }

        // Nổi bật
        if ($request->filled('is_featured')) {
            $query->where('is_featured', 1);
        }

        // Sắp xếp
        $sort = $request->input('sort', 'newest');
        switch ($sort) {
            case 'views':
                $query->orderByDesc('views');
                break;
            case 'salary':
                $query->orderByDesc('salary_min');
                break;
            default:
                $query->orderByDesc('created_at');
        }

        return $query;
    }

    /**
     * Trang chi tiết việc làm
     */
    public function show($slug)
    {
        $job = Job::with([
            'company',
            'skills',
            'jobType',
            'location',
            'category',
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
