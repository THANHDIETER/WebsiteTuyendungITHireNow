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
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Schema;

class JobController extends Controller
{
    /** Trang danh sách mặc định */
    public function index(Request $request)
    {
        $perPage = $this->sanitizePerPage($request->input('per_page', 9));

        $base = Job::with(['company','skills','jobType','location','level','experience','language'])
            ->where('status', 'published');

        $jobs = (clone $base)->orderByDesc('created_at')
            ->paginate($perPage)
            ->appends($request->except('page'));

        [$categories, $companies, $skills, $locations, $jobTypes, $levels, $experiences, $languages, $currencies] = $this->filtersData();

        return view('website.jobs.job', compact(
            'jobs','categories','companies','skills','locations',
            'jobTypes','levels','experiences','languages','currencies'
        ));
    }

    /** Trang tìm kiếm (lọc nâng cao) */
    public function search(Request $request)
    {
        $perPage    = $this->sanitizePerPage($request->input('per_page', 9));
        $skills     = $this->parseSkills($request->input('skills'));
        $skillsMode = strtolower($request->input('skills_mode', 'any')); // any|all
        $sort       = $request->input('sort', $request->filled('q') ? 'relevance' : 'newest');

        $query = $this->buildQuery($request, $skills, $skillsMode);
        $jobs  = $this->applySort($query, $sort, $request->input('q'))
            ->paginate($perPage)
            ->appends($request->except('page'));

        [$categories, $companies, $skillsList, $locations, $jobTypes, $levels, $experiences, $languages, $currencies] = $this->filtersData();

        return view('website.jobs.job', [
            'jobs'        => $jobs,
            'categories'  => $categories,
            'companies'   => $companies,
            'skills'      => $skillsList,
            'locations'   => $locations,
            'jobTypes'    => $jobTypes,
            'levels'      => $levels,
            'experiences' => $experiences,
            'languages'   => $languages,
            'currencies'  => $currencies,
        ]);
    }

    /** Trang chi tiết (không đổi) */
    public function show($slug)
    {
        $job = Job::with([
            'company','skills','jobType','location','category',
            'level','experience','language','remotePolicy',
        ])->where('slug', $slug)->where('status', 'published')->firstOrFail();

        $relatedJobs = collect();

        return view('website.jobs.job-details', compact('job','relatedJobs'));
    }

    /* ======================= Helpers ======================= */

    private function buildQuery(Request $request, array $skills, string $skillsMode): Builder
    {
        $q = Job::with(['company','skills','jobType','location','level','experience','language'])
            ->where('status', 'published');

        // Từ khóa
        if ($request->filled('q')) {
            $kw = trim($request->input('q'));
            $like = "%{$kw}%";
            $q->where(function (Builder $sub) use ($like) {
                $sub->where('title','like',$like)
                    ->orWhere('description','like',$like)
                    ->orWhere('requirements','like',$like)
                    ->orWhere('benefits','like',$like)
                    ->orWhere('meta_title','like',$like)
                    ->orWhere('meta_description','like',$like)
                    ->orWhere('keyword','like',$like);
            });
        }

        // Category: hỗ trợ 1-n (jobs.category_id) và many-to-many (jobs<->categories)
        $categoryIds = [];
        if ($request->filled('category_id')) $categoryIds[] = (int)$request->input('category_id');
        if ($request->filled('categories')) {
            $raw = $request->input('categories');
            if (is_string($raw)) $raw = explode(',', $raw);
            foreach ((array)$raw as $cid) if ((int)$cid) $categoryIds[] = (int)$cid;
        }
        $categoryIds = array_values(array_unique(array_filter($categoryIds)));

        if (!empty($categoryIds)) {
            if (Schema::hasColumn('jobs', 'category_id')) {
                count($categoryIds) > 1
                    ? $q->whereIn('category_id', $categoryIds)
                    : $q->where('category_id', $categoryIds[0]);
            } else {
                $q->whereHas('categories', fn($c)=>$c->whereIn('categories.id',$categoryIds));
            }
        }

        // Filter ID khác (trên bảng jobs)
        foreach (['location_id','company_id','job_type_id','level_id','experience_id','language_id','remote_policy_id'] as $col) {
            if ($request->filled($col)) $q->where($col, $request->input($col));
        }

        // Tiền tệ
        if ($request->filled('currency')) {
            $q->where('currency', $request->input('currency'));
        }

        // Lương: khoảng giao nhau
        $min = (int)$request->input('min_salary');
        $max = (int)$request->input('max_salary');
        if ($min || $max) {
            $q->where(function (Builder $w) use ($min, $max) {
                if ($min && $max) {
                    $w->whereBetween('salary_min', [$min, $max])
                      ->orWhereBetween('salary_max', [$min, $max])
                      ->orWhere(function (Builder $ww) use ($min, $max) {
                          $ww->where('salary_min','<=',$min)->where('salary_max','>=',$max);
                      });
                } elseif ($min) {
                    $w->where('salary_max','>=',$min);
                } else {
                    $w->where('salary_min','<=',$max);
                }
            });
        }

        // Kỹ năng: ANY/ALL
        if (!empty($skills)) {
            if ($skillsMode === 'all') {
                foreach ($skills as $sid) {
                    $q->whereHas('skills', fn($s)=>$s->where('skills.id', $sid));
                }
            } else {
                $q->whereHas('skills', fn($s)=>$s->whereIn('skills.id', $skills));
            }
        }

        // Nổi bật
        if ($request->boolean('is_featured')) $q->where('is_featured', 1);

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
            )->orderByDesc('created_at');
        }

        return match ($sort) {
            'views'  => $query->orderByDesc('views'),
            'salary' => $query->orderByDesc('salary_min')->orderByDesc('salary_max'),
            default  => $query->orderByDesc('created_at'),
        };
    }

    private function sanitizePerPage($val): int
    {
        $pp = (int)$val;
        return max(6, min(50, $pp ?: 9));
    }

    private function parseSkills($skills): array
    {
        if (is_array($skills))  return array_values(array_filter($skills, fn($v)=>trim($v) !== ''));
        if (is_string($skills)) return array_values(array_filter(array_map('trim', explode(',', $skills))));
        return [];
    }

    /** cột order an toàn */
    private function pickOrderable(string $table, array $candidates, string $fallback = 'id'): string
    {
        foreach ($candidates as $col) if (Schema::hasColumn($table, $col)) return $col;
        return $fallback;
    }

    /** lấy list currency (distinct) */
    private function currenciesList(): array
    {
        $list = Job::query()->select('currency')->whereNotNull('currency')->distinct()
            ->pluck('currency')->filter()->values()->all();
        return $list ?: ['VND','USD','EUR'];
    }

    /** dữ liệu filter */
    private function filtersData(): array
    {
        $categoriesOrder  = $this->pickOrderable('categories',  ['name','slug','category_name']);
        $companiesOrder   = $this->pickOrderable('companies',   ['name','company_name','slug']);
        $skillsOrder      = $this->pickOrderable('skills',      ['skill_name','name','slug']);
        $locationsOrder   = $this->pickOrderable('locations',   ['name','city','slug']);
        $jobTypesOrder    = $this->pickOrderable('job_types',   ['name','type_name','slug']);
        $levelsOrder      = $this->pickOrderable('levels',      ['name','level_name']);
        $expOrder         = $this->pickOrderable('job_experiences', ['name']);
        $langOrder        = $this->pickOrderable('job_languages',   ['name','language_name']);

        $categories  = Category::orderBy($categoriesOrder)->get();
        $companies   = Company::orderBy($companiesOrder)->get();
        $skills      = Skill::orderBy($skillsOrder)->get();
        $locations   = Location::orderBy($locationsOrder)->get();
        $jobTypes    = JobType::orderBy($jobTypesOrder)->get();
        $levels      = Level::orderBy($levelsOrder)->get();
        $experiences = JobExperience::orderBy($expOrder)->get();
        $languages   = JobLanguage::orderBy($langOrder)->get();
        $currencies  = $this->currenciesList();

        return [$categories, $companies, $skills, $locations, $jobTypes, $levels, $experiences, $languages, $currencies];
    }
}
