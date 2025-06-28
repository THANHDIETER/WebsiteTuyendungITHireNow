<?php

namespace App\Http\Controllers\Employers;

use App\Models\Job;
use App\Models\Level;
use App\Models\Skill;
use App\Models\JobType;
use App\Models\Category;
use App\Models\Location;
use App\Models\JobLanguage;
use Illuminate\Support\Str;
use App\Models\RemotePolicy;
use Illuminate\Http\Request;
use App\Models\JobExperience;
use App\Models\EmployerPackageLog;
use App\Models\EmployerFreePosting;
use App\Http\Controllers\Controller;
use App\Models\EmployerPackageUsage;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
{
    $user = Auth::user();

    if (!$user || !$user->company) {
        return redirect()->route('employer.dashboard')->withErrors('Bạn chưa có thông tin công ty.');
    }

    $jobs = Job::with(['categories', 'jobType']) // Load thêm jobType
                ->where('company_id', $user->company->id)
                ->latest()
                ->paginate(10);

    return view('employer.jobs.index', compact('jobs'));
}


    public function create()
{
    $user = Auth::user();
    $company = $user->company;
    $jobTypes = JobType::where('is_active', true)->get();

    $company_addresses = is_array($company->address) ? $company->address : ($company->address ? [$company->address] : []);
    $locations = Location::where('is_active', true)->orderBy('name')->get();
    $categories = Category::all();
    $skills = Skill::where('is_active', true)->pluck('skill_name');
    $skills = Skill::where('is_active', true)->get();
    $levels = Level::where('is_active', true)->get();
    $experiences = JobExperience::where('is_active', true)->get();
    $languages = JobLanguage::where('is_active', true)->get();
    $remote_policies = RemotePolicy::where('is_active', true)->get();

    return view('employer.jobs.create', compact(
        'categories', 'jobTypes', 'skills', 'company_addresses','locations', 'levels', 'experiences', 'languages', 'remote_policies'
    ));
}

  public function store(Request $request)
{
    $user = Auth::user();
    $company = $user->company;

    if (!$company) {
        return redirect()->route('employer.dashboard')->withErrors('Bạn chưa có thông tin công ty.');
    }

    // Kiểm tra lượt đăng miễn phí
    $freePosting = EmployerFreePosting::firstOrCreate(
        ['company_id' => $company->id],
        [
            'post_limit' => 5,
            'post_used' => 0,
            'reset_at' => now()->addDays(7),
        ]
    );

    if (now()->greaterThan($freePosting->reset_at)) {
        $freePosting->update([
            'post_used' => 0,
            'reset_at' => now()->addDays(7),
        ]);
    }

    $freeRemain = $freePosting->post_limit - $freePosting->post_used;

    // Kiểm tra lượt đăng theo gói
    $packageUsage = EmployerPackageUsage::where('company_id', $company->id)
        ->where('is_active', true)
        ->first();
    $packageRemain = $packageUsage ? ($packageUsage->post_limit - $packageUsage->posts_used) : 0;

    if ($freeRemain + $packageRemain <= 0) {
        return redirect()->route('employer.packages.index')->with('error', 'Bạn đã hết lượt đăng tin. Vui lòng mua gói.');
    }

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'requirements' => 'nullable|string',
        'thumbnail' => 'nullable|image|max:2048',
        'benefits' => 'nullable|string',
        'salary_min' => 'nullable|numeric|min:0',
        'salary_max' => 'nullable|numeric|min:0',
        'salary_negotiable' => 'nullable',
        'address' => 'nullable|string|max:255',
        'language_id' => 'nullable|exists:job_languages,id',
        'experience_id' => 'nullable|exists:job_experiences,id',
        'remote_policy_id' => 'nullable|exists:remote_policies,id',
        'level_id' => 'nullable|exists:levels,id',
        'location_id' => 'nullable|exists:locations,id',
        'categories' => 'required|array',
        'categories.*' => 'integer|exists:categories,id',
        'skills_text' => 'nullable|string',
        'application_deadline' => 'nullable|date|after_or_equal:today',
        'meta_title' => 'nullable|string|max:150',
        'meta_description' => 'nullable|string',
        'keyword' => 'nullable|string|max:150',
        'search_index' => 'nullable|boolean',
        'currency' => 'nullable|string|max:10',
        'job_type_id' => 'required|exists:job_types,id',
    ]);
    if ($request->hasFile('thumbnail')) {
        $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
    }

    $validated['deadline'] = $request->input('application_deadline') ?? null;
    $validated['currency'] = $validated['currency'] ?? 'VND';
    $validated['salary_negotiable'] = $request->boolean('salary_negotiable', false);

    if ($validated['salary_negotiable']) {
        $validated['salary_display'] = 'Lương thương lượng';
    } elseif ($validated['salary_min'] && $validated['salary_max']) {
        $validated['salary_display'] = number_format($validated['salary_min']) . ' - ' . number_format($validated['salary_max']) . ' ' . $validated['currency'];
    } elseif ($validated['salary_min']) {
        $validated['salary_display'] = 'Từ ' . number_format($validated['salary_min']) . ' ' . $validated['currency'];
    } elseif ($validated['salary_max']) {
        $validated['salary_display'] = 'Up to ' . number_format($validated['salary_max']) . ' ' . $validated['currency'];
    } else {
        $validated['salary_display'] = 'Thoả thuận';
    }

    $validated['company_id'] = $company->id;
    $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
    $validated['status'] = 'pending';
    $validated['is_approved'] = false;
    $validated['views'] = 0;
    $validated['is_featured'] = false;
    $validated['search_index'] = $request->boolean('search_index', false);
    $validated['is_paid'] = $freeRemain <= 0;
    $validated['category_id'] = $validated['categories'][0];
    $validated['job_type'] = $request->input('job_type') ?? 'full-time';

    $job = Job::create($validated);

    if ($freeRemain > 0) {
        $freePosting->increment('post_used');
    } elseif ($packageRemain > 0 && $packageUsage) {
        $packageUsage->increment('posts_used');
        EmployerPackageLog::create([
            'order_id' => $packageUsage->order_id,
            'job_id' => $job->id,
            'used_at' => now(),
            'action' => 'create',
        ]);
    }

    // Gắn skills
    if ($request->filled('skills_text')) {
        $skillNames = array_filter(array_map('trim', explode(',', $request->input('skills_text'))));
        $skillIds = [];
        foreach ($skillNames as $skillName) {
            $skill = Skill::firstOrCreate(
                ['skill_name' => $skillName],
                [
                    'slug' => Str::slug($skillName),
                    'group_name' => 'Chưa phân loại',
                    'is_active' => true,
                    'user_id' => auth()->id(),
                ]
            );
            $skillIds[] = $skill->id;
        }
        $job->skills()->sync($skillIds);
    } else {
        $job->skills()->detach();
    }

    $job->categories()->sync($validated['categories']);

    return redirect()->route('employer.jobs.index')->with('success', 'Tin đã được gửi và đang chờ duyệt.');
}

    public function edit($id)
{
    $user = Auth::user();
    $company = $user->company;

    $job = $company->jobs()->with(['skills', 'categories'])->findOrFail($id);
    $jobTypes = JobType::where('is_active', true)->get(); // hoặc tất cả

    $locations = Location::where('is_active', true)->orderBy('name')->get();
    $categories = Category::all();
    $skills = Skill::all();
    $levels = Level::where('is_active', true)->get();
    $experiences = JobExperience::where('is_active', true)->get();
    $languages = JobLanguage::where('is_active', true)->get();
    $remote_policies = RemotePolicy::where('is_active', true)->get();

    // ✅ Thêm địa chỉ từ thông tin công ty
    $company_addresses = $company->addresses ?? []; // hoặc $company->getAddressList() nếu bạn có hàm hỗ trợ

    // Kỹ năng đã chọn (hiển thị trong input skills_text)
    $selectedSkills = $job->skills->pluck('skill_name')->implode(', ');

    // Ngành nghề đã chọn
    $selectedCategories = $job->categories->pluck('id')->toArray();

    return view('employer.jobs.edit', compact(
        'job',
        'categories',
        'skills','levels','experiences','languages','remote_policies', 'locations','company_addresses','selectedSkills','selectedCategories', 'jobTypes'
    ));
}



    public function update(Request $request, $id)
{
    $user = Auth::user();
    $company = $user->company;
    $job = $company->jobs()->findOrFail($id);

    $validated = $request->validate([
        'title' => 'required|string|max:255',
        'description' => 'nullable|string',
        'requirements' => 'nullable|string',
        'benefits' => 'nullable|string',
        'salary_min' => 'nullable|numeric|min:0',
        'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
        'address' => 'nullable|string|max:255',
        'level_id' => 'nullable|exists:levels,id',
        'experience_id' => 'nullable|exists:job_experiences,id',
        'language_id' => 'nullable|exists:job_languages,id',
        'remote_policy_id' => 'nullable|exists:remote_policies,id',
        'location_id' => 'nullable|exists:locations,id',
        'categories' => 'required|array',
        'categories.*' => 'integer|exists:categories,id',
        'skills_text' => 'nullable|string',
        'application_deadline' => 'nullable|date|after_or_equal:today',
        'meta_title' => 'nullable|string|max:150',
        'meta_description' => 'nullable|string',
        'keyword' => 'nullable|string|max:150',
        'search_index' => 'nullable|boolean',
        'currency' => 'nullable|string|max:10',
        'apply_url' => 'nullable|url',
        'job_type' => 'nullable|in:full-time,part-time,internship,remote,freelance',
    ]);

    $validated['deadline'] = $request->input('application_deadline') ?? null;
    $validated['search_index'] = $request->boolean('search_index', false);
    $validated['salary_negotiable'] = $request->boolean('salary_negotiable', false);
    $validated['currency'] = $validated['currency'] ?? 'VND';

    // Tính salary_display
    if ($validated['salary_negotiable']) {
        $validated['salary_display'] = 'Lương thương lượng';
    } elseif ($validated['salary_min'] && $validated['salary_max']) {
        $validated['salary_display'] = number_format($validated['salary_min']) . ' - ' . number_format($validated['salary_max']) . ' ' . $validated['currency'];
    } elseif ($validated['salary_min']) {
        $validated['salary_display'] = 'Từ ' . number_format($validated['salary_min']) . ' ' . $validated['currency'];
    } elseif ($validated['salary_max']) {
        $validated['salary_display'] = 'Up to ' . number_format($validated['salary_max']) . ' ' . $validated['currency'];
    } else {
        $validated['salary_display'] = 'Thoả thuận';
    }

    $job->update($validated);

    // Cập nhật kỹ năng
    if ($request->filled('skills_text')) {
        $skillNames = array_filter(array_map('trim', explode(',', $request->input('skills_text'))));
        $skillIds = [];
        foreach ($skillNames as $skillName) {
            $skill = Skill::firstOrCreate(
                ['skill_name' => $skillName],
                [
                    'slug' => Str::slug($skillName),
                    'group_name' => 'Chưa phân loại',
                    'is_active' => true,
                    'user_id' => auth()->id(),
                ]
            );
            $skillIds[] = $skill->id;
        }
        $job->skills()->sync($skillIds);
    } else {
        $job->skills()->detach();
    }

    // Cập nhật ngành nghề
    $job->categories()->sync($validated['categories']);

    return redirect()->route('employer.jobs.show', $job->id)->with('success', 'Cập nhật thành công.');
}


    public function close($id)
    {
        $job = Job::where('company_id', Auth::user()->company->id)->findOrFail($id);
        $job->status = 'closed';
        $job->save();

        return redirect()->route('employer.jobs.index')->with('success', 'Tin đã được ngừng tuyển.');
    }

    public function show($id)
    {
        $job = Job::with([
            'company',
            'categories',
            'skills',
            'level',
            'experience',
            'remotePolicy',
            'language',
            'jobType' ,
        ])->findOrFail($id);

        return view('employer.jobs.show', compact('job'));
    }


}
