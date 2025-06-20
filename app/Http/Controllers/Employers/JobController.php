<?php

namespace App\Http\Controllers\Employers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        if (!$user || !$user->company) {
            return redirect()->route('employer.dashboard')->withErrors('Bạn chưa có thông tin công ty.');
        }

        $jobs = Job::with(['category'])->where('company_id', $user->company->id)->latest()->paginate(10);
        return view('employer.jobs.index', compact('jobs'));
    }

    public function create()
    {
        $user = Auth::user();
        $company = $user->company;
        $company_addresses = is_array($company->address)
            ? $company->address
            : ($company->address ? [$company->address] : []);

        $categories = Category::all();
        $skills = Skill::where('is_active', true)->get();
        $levels = ['Intern', 'Junior', 'Middle', 'Senior', 'Lead', 'Manager'];
        $experiences = ['Không yêu cầu', '1 năm', '2 năm', '3 năm', '5 năm+'];

        return view('employer.jobs.create', compact(
            'categories',
            'skills',
            'company_addresses',
            'levels',
            'experiences'
        ));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('employer.dashboard')->withErrors('Bạn chưa có thông tin công ty.');
        }

        if (!$company->free_post_quota_expired_at) {
            $company->free_post_quota_expired_at = now()->addDays(7);
            $company->free_post_quota_used = 0;
            $company->save();
        }

        $freeQuotaStillValid = now()->lt($company->free_post_quota_expired_at);
        $freeRemain = $freeQuotaStillValid ? max($company->free_post_quota - $company->free_post_quota_used, 0) : 0;
        $package = $company->activeEmployerPackage();
        $packageRemain = $package ? ($package->post_limit - $package->posts_used) : 0;

        if ($freeRemain + $packageRemain <= 0) {
            return redirect()->route('employer.packages.index')->with('error', 'Bạn đã hết lượt đăng tin. Vui lòng mua gói.');
        }

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'requirements' => 'nullable|string',
            'description_file' => 'nullable|file|mimes:pdf,doc,docx|max:2048',
            'thumbnail' => 'nullable|image|max:2048',
            'benefits' => 'nullable|string',
            'salary_min' => 'nullable|numeric|min:0',
            'salary_max' => 'nullable|numeric|min:0|gte:salary_min',
            'address' => 'nullable|string|max:255',
            'level' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'categories' => 'required|array',
            'categories.*' => 'integer|exists:categories,id',
            'skills' => 'nullable|array',
            'skills.*' => 'integer|exists:skills,id',
            'application_deadline' => 'nullable|date|after_or_equal:today',
            'meta_title' => 'nullable|string|max:150',
            'meta_description' => 'nullable|string',
            'keyword' => 'nullable|string|max:150',
            'search_index' => 'nullable|boolean',
            'currency' => 'nullable|string|max:10',
            'apply_url' => 'nullable|url',
            'remote_policy' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:50',
        ]);

        if ($request->hasFile('description_file')) {
            $path = $request->file('description_file')->store('job_descriptions', 'public');
            $validated['description'] = '<a href="' . asset('storage/' . $path) . '" target="_blank">Xem mô tả công việc đính kèm</a>';
        }

        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $validated['company_id'] = $company->id;
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['status'] = 'pending';
        $validated['is_approved'] = false;
        $validated['views'] = 0;
        $validated['is_featured'] = false;
        $validated['search_index'] = $request->boolean('search_index', false);
        $validated['currency'] = $validated['currency'] ?? 'VND';
        $validated['category_id'] = $validated['categories'][0];

        if ($freeRemain > 0) {
            $validated['is_paid'] = false;
            $company->increment('free_post_quota_used');
        } elseif ($packageRemain > 0 && $package) {
            $validated['is_paid'] = true;
            $package->increment('posts_used');
        }

        $job = Job::create($validated);

        if ($request->filled('skills')) {
            $job->skills()->sync($request->input('skills'));
        }

        return redirect()->route('employer.jobs.index')->with('success', 'Tin đã được gửi và đang chờ duyệt.');
    }

    public function edit($id)
    {
        $user = Auth::user();
        $company = $user->company;
        $job = $company->jobs()->with('skills')->findOrFail($id);

        $categories = Category::all();
        $skills = Skill::all();
        $selectedSkills = $job->skills->pluck('id')->toArray();
        $levels = ['Intern', 'Junior', 'Middle', 'Senior', 'Lead', 'Manager'];
        $experiences = ['Không yêu cầu', '1 năm', '2 năm', '3 năm', '5 năm+'];

        return view('employer.jobs.edit', compact('job', 'categories', 'skills', 'selectedSkills', 'levels', 'experiences'));
    }
    public function close($id)
    {
        $job = Job::where('company_id', Auth::user()->company->id)->findOrFail($id);
        $job->status = 'closed';
        $job->save();

        return redirect()->route('employer.jobs.index')->with('success', 'Tin đã được ngừng tuyển.');
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
            'level' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'skills' => 'nullable|array',
            'skills.*' => 'integer|exists:skills,id',
            'application_deadline' => 'nullable|date|after_or_equal:today',
            'meta_title' => 'nullable|string|max:150',
            'meta_description' => 'nullable|string',
            'keyword' => 'nullable|string|max:150',
            'search_index' => 'nullable|boolean',
            'currency' => 'nullable|string|max:10',
            'apply_url' => 'nullable|url',
            'remote_policy' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:50',
        ]);

        $validated['search_index'] = $request->boolean('search_index', false);
        $validated['currency'] = $validated['currency'] ?? 'VND';

        $job->update($validated);

        if ($request->filled('skills')) {
            $job->skills()->sync($request->input('skills'));
        } else {
            $job->skills()->detach();
        }

        return redirect()->route('employer.jobs.show', $job->id)->with('success', 'Cập nhật thành công.');
    }

    public function show($id)
    {
        $job = Job::with(['company', 'category', 'skills'])->findOrFail($id);
        return view('employer.jobs.show', compact('job'));
    }
}
