<?php

namespace App\Http\Controllers;

use App\Models\Job;
use App\Models\Level;
use App\Models\Skill;
use App\Models\Company;
use App\Models\JobType;
use App\Models\JobView;
use App\Models\Category;
use App\Models\Location;
use App\Models\JobLanguage;
use Illuminate\Http\Request;
use App\Models\JobExperience;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Builder;

class JobController extends Controller
{
    public function index(Request $request)
    {
        $title = 'tìm việc làm';
        $perPage = $this->sanitizePerPage($request->input('per_page', 6));
        $view = $request->input('view', 'grid');

        $base = Job::withRelations()->where('status', 'published');

        $jobs = (clone $base)->latest('created_at')
            ->paginate($perPage)
            ->appends($request->except('page'));

        [$categories, $companies, $skills, $locations, $jobTypes, $levels, $experiences, $languages, $currencies] = $this->filtersData();
        $sortDefault = 'newest';

        return view('website.jobs.job', compact(
            'jobs',
            'categories',
            'companies',
            'skills',
            'locations',
            'view',
            'jobTypes',
            'levels',
            'experiences',
            'languages',
            'currencies',
            'sortDefault',
            'perPage',
            'title'
        ));
    }

    public function search(Request $request)
    {
        $perPage = $this->sanitizePerPage($request->input('per_page', 9));
        $skills = $this->parseSkills($request->input('skills'));
        $skillsMode = strtolower($request->input('skills_mode', 'any')); // any|all
        $sort = $request->input('sort', $request->filled('q') ? 'relevance' : 'newest');

        $query = $this->buildQuery($request, $skills, $skillsMode);
        $jobs = $this->applySort($query, $sort, $request->input('q'))
            ->paginate($perPage)
            ->appends($request->except('page'));

        [$categories, $companies, $skillsList, $locations, $jobTypes, $levels, $experiences, $languages, $currencies] = $this->filtersData();

        return view('website.jobs.job', compact(
            'jobs',
            'categories',
            'companies',
            'skills',
            'locations',
            'jobTypes',
            'levels',
            'experiences',
            'languages',
            'currencies'
        ));
    }

    private function filtersData(): array
    {
        $categoriesOrder = $this->pickOrderable('categories', ['name', 'slug', 'category_name']);
        $companiesOrder = $this->pickOrderable('companies', ['name', 'company_name', 'slug']);
        $skillsOrder = $this->pickOrderable('skills', ['skill_name', 'name', 'slug']);
        $locationsOrder = $this->pickOrderable('locations', ['name', 'city', 'slug']);
        $jobTypesOrder = $this->pickOrderable('job_types', ['name', 'type_name', 'slug']);
        $levelsOrder = $this->pickOrderable('levels', ['name', 'level_name']);
        $expOrder = $this->pickOrderable('job_experiences', ['name']);
        $langOrder = $this->pickOrderable('job_languages', ['name', 'language_name']);

        $categories = Cache::remember('jobs:categories_active', 3600, function () use ($categoriesOrder) {
            return Category::where('is_active', true)
                ->withCount(['jobs as jobs_count' => fn($q) => $q->where('status', 'published')])
                ->having('jobs_count', '>', 0)
                ->orderBy($categoriesOrder)
                ->get();
        });

        $companies = Cache::remember('jobs:companies', 3600, fn() => Company::orderBy($companiesOrder)->get());
        $skills = Cache::remember('jobs:skills', 3600, fn() => Skill::orderBy($skillsOrder)->get());
        $locations = Cache::remember('jobs:locations', 3600, fn() => Location::orderBy($locationsOrder)->get());
        $jobTypes = Cache::remember('jobs:jobtypes', 3600, fn() => JobType::orderBy($jobTypesOrder)->get());
        $levels = Cache::remember('jobs:levels', 3600, fn() => Level::orderBy($levelsOrder)->get());
        $experiences = Cache::remember('jobs:experiences', 3600, fn() => JobExperience::orderBy($expOrder)->get());
        $languages = Cache::remember('jobs:languages', 3600, fn() => JobLanguage::orderBy($langOrder)->get());
        $currencies = $this->currenciesList();

        return [$categories, $companies, $skills, $locations, $jobTypes, $levels, $experiences, $languages, $currencies];
    }

    private function buildQuery(Request $request, array $skills, string $skillsMode): Builder
    {
        $q = Job::withRelations()->where('status', 'published');

        // 🔍 Từ khóa
        if ($request->filled('q')) {
            $kw = trim($request->input('q'));
            $like = "%{$kw}%";
            $q->where(function (Builder $sub) use ($like) {
                $sub->where('title', 'like', $like)
                    ->orWhere('description', 'like', $like)
                    ->orWhere('requirements', 'like', $like)
                    ->orWhere('benefits', 'like', $like)
                    ->orWhere('meta_title', 'like', $like)
                    ->orWhere('meta_description', 'like', $like)
                    ->orWhere('keyword', 'like', $like);
            });
        }

        // 📌 Category
        $categoryIds = collect((array) $request->input('categories', []))
            ->merge([$request->input('category_id')])
            ->filter()->map(fn($id) => (int) $id)->unique()->values()->all();

        if (!empty($categoryIds)) {
            if (Schema::hasColumn('jobs', 'category_id')) {
                $q->whereIn('category_id', $categoryIds);
            } else {
                $q->whereHas('categories', fn($c) => $c->whereIn('categories.id', $categoryIds));
            }
        }

        // 📌 Filter khác (foreign keys)
        foreach (['location_id', 'company_id', 'job_type_id', 'level_id', 'experience_id', 'language_id', 'remote_policy_id'] as $col) {
            if ($request->filled($col))
                $q->where($col, $request->input($col));
        }

        // 📌 Tiền tệ
        if ($request->filled('currency'))
            $q->where('currency', $request->input('currency'));

        // 📌 Lương
        $min = (int) $request->input('min_salary');
        $max = (int) $request->input('max_salary');
        if ($min || $max) {
            $q->where(function ($w) use ($min, $max) {
                if ($min)
                    $w->where('salary_max', '>=', $min);
                if ($max)
                    $w->where('salary_min', '<=', $max);
            });
        }

        // 📌 Kỹ năng
        if (!empty($skills)) {
            if ($skillsMode === 'all') {
                foreach ($skills as $sid) {
                    $q->whereHas('skills', fn($s) => $s->where('skills.id', $sid));
                }
            } else {
                $q->whereHas('skills', fn($s) => $s->whereIn('skills.id', $skills));
            }
        }

        // 📌 Việc nổi bật
        if ($request->boolean('is_featured'))
            $q->where('is_featured', 1);

        return $q;
    }

    private function applySort(Builder $query, string $sort, ?string $kw): Builder
    {
        $sort = strtolower($sort);

        if ($sort === 'relevance' && $kw) {
            $kw = trim($kw);
            return $query->orderByRaw(
                "(CASE
                    WHEN title = ? THEN 6
                    WHEN title LIKE ? THEN 5
                    WHEN title LIKE ? THEN 4
                    WHEN description LIKE ? THEN 3
                    WHEN requirements LIKE ? THEN 2
                    ELSE 1
                 END) DESC",
                [$kw, "{$kw}%", "%{$kw}%", "%{$kw}%", "%{$kw}%"]
            )->latest('created_at');
        }

        return match ($sort) {
            'views' => $query->orderByDesc('views'),
            'salary' => $query->orderByDesc('salary_min')->orderByDesc('salary_max'),
            default => $query->latest('created_at'),
        };
    }

    private function sanitizePerPage($val): int
    {
        $pp = (int) $val;
        return max(6, min(50, $pp ?: 9));
    }

    private function parseSkills($skills): array
    {
        if (is_array($skills))
            return array_values(array_filter($skills, fn($v) => trim($v) !== ''));
        if (is_string($skills))
            return array_values(array_filter(array_map('trim', explode(',', $skills))));
        return [];
    }

    private function pickOrderable(string $table, array $candidates, string $fallback = 'id'): string
    {
        foreach ($candidates as $col)
            if (Schema::hasColumn($table, $col))
                return $col;
        return $fallback;
    }

    private function currenciesList(): array
    {
        $list = Job::query()->select('currency')->whereNotNull('currency')->distinct()
            ->pluck('currency')->filter()->values()->all();
        return $list ?: ['VND', 'USD'];
    }

    public function show(Request $request, $slug)
    {
        $job = Cache::remember("jobs:detail:$slug", 600, function () use ($slug) {
            return Job::withRelations()
                ->where('slug', $slug)
                ->where('status', 'published')
                ->firstOrFail();
        });

        $user = Auth::user();
        $profile = $user->profile ?? null;
        $cvs = $profile?->cvs()->get() ?? collect();
        $ip = $request->ip();

        $alreadyViewed = JobView::where('job_id', $job->id)
            ->where(function ($query) use ($user, $ip) {
                if ($user) {
                    // Nếu có user_id => check theo user_id hoặc ip_address
                    $query->where('user_id', $user->id)
                        ->orWhere('ip_address', $ip);
                } else {
                    // Nếu chưa login => check theo ip
                    $query->where('ip_address', $ip);
                }
            })
            ->whereDate('created_at', now()->toDateString())
            ->exists();

        if (!$alreadyViewed) {
            $job->increment('views');

            JobView::create([
                'job_id' => $job->id,
                'user_id' => $user?->id,
                'ip_address' => $ip,
            ]);
        }
        // Gợi ý việc làm liên quan
        $relatedJobs = Cache::remember("jobs:related:{$job->id}", 600, function () use ($job) {
            return Job::with(['company:id,name,logo_url,phone', 'location:id,name', 'category:id,name'])
                ->where('status', 'published')
                ->where('id', '!=', $job->id)
                ->where(function ($q) use ($job) {
                    $q->when($job->category_id, fn($q) => $q->orWhere('category_id', $job->category_id))
                        ->when($job->location_id, fn($q) => $q->orWhere('location_id', $job->location_id))
                        ->when($job->level_id, fn($q) => $q->orWhere('level_id', $job->level_id));
                })
                ->latest('created_at')
                ->limit(6)
                ->get();
        });

        return view('website.jobs.job-details', compact('job', 'relatedJobs', 'cvs', 'profile'));
    }
}
