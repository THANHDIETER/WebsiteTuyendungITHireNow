<?php

namespace App\Http\Controllers\Employers;

use App\Models\Job;
use App\Models\Category;
use App\Models\Skill;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Models\User;
use App\Notifications\Admin\JobEditedNotification;
use App\Notifications\Admin\NewJobSubmittedNotification;
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
        $company_addresses = is_array($company->address) ? $company->address : ($company->address ? [$company->address] : []);

        $categories = Category::all();
        $skills = Skill::where('is_active', true)->get();
        $levels = ['Intern', 'Junior', 'Middle', 'Senior', 'Lead', 'Manager'];
        $experiences = ['Không yêu cầu', '1 năm', '2 năm', '3 năm', '5 năm+'];
        $languages = ['Tiếng Việt', 'Tiếng Anh', 'Song ngữ', 'Khác'];
        $remote_policies = ['Onsite', 'Remote', 'Hybrid'];

        return view('employer.jobs.create', compact(
            'categories',
            'skills',
            'company_addresses',
            'levels',
            'experiences',
            'languages',
            'remote_policies'
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

        $freeRemain = now()->lt($company->free_post_quota_expired_at) ? max($company->free_post_quota - $company->free_post_quota_used, 0) : 0;
        $package = $company->activeEmployerPackage();
        $packageRemain = $package ? ($package->post_limit - $package->posts_used) : 0;

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
            'level' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
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
            'remote_policy' => 'nullable|string|max:100',
            'language' => 'nullable|string|max:50',
        ]);

        // Handle thumbnail
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        // Xử lý deadline
        $validated['deadline'] = $request->input('application_deadline') ?? null;

        // Xử lý salary display
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

        // Ghi thông tin hệ thống
        $validated['company_id'] = $company->id;
        $validated['slug'] = Str::slug($validated['title']) . '-' . uniqid();
        $validated['status'] = 'pending';
        $validated['is_approved'] = false;
        $validated['views'] = 0;
        $validated['is_featured'] = false;
        $validated['search_index'] = $request->boolean('search_index', false);
        $validated['category_id'] = $validated['categories'][0];

        if ($freeRemain > 0) {
            $validated['is_paid'] = false;
            $company->increment('free_post_quota_used');
        } elseif ($packageRemain > 0 && $package) {
            $validated['is_paid'] = true;
            $package->increment('posts_used');
        }

        // Tạo job
        $job = Job::create($validated);

        // Gửi thông báo cho tất cả admin
        $admins = User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewJobSubmittedNotification($job));
        }

        // Xử lý kỹ năng (map từ text sang bảng Skill)
        if ($request->filled('skills_text')) {
            $skillNames = array_filter(array_map('trim', explode(',', $request->input('skills_text'))));
            if (!empty($skillNames)) {
                $skillIds = Skill::whereIn('skill_name', $skillNames)->pluck('id')->toArray();
                $job->skills()->sync($skillIds);
            } else {
                $job->skills()->detach();
            }
        } else {
            $job->skills()->detach();
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
        $levels = ['Intern', 'Junior', 'Middle', 'Senior', 'Lead', 'Manager'];
        $experiences = ['Không yêu cầu', '1 năm', '2 năm', '3 năm', '5 năm+'];
        $languages = ['Tiếng Việt', 'Tiếng Anh', 'Song ngữ', 'Khác'];
        $remote_policies = ['Onsite', 'Remote', 'Hybrid'];

        // Đưa dữ liệu kỹ năng ra dạng chuỗi kỹ năng_text
        $selectedSkills = $job->skills->pluck('name')->implode(', ');

        return view('employer.jobs.edit', compact(
            'job',
            'categories',
            'skills',
            'levels',
            'experiences',
            'languages',
            'remote_policies',
            'selectedSkills'
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
            'level' => 'nullable|string|max:255',
            'experience' => 'nullable|string|max:255',
            'category_id' => 'required|integer|exists:categories,id',
            'skills_text' => 'nullable|string',
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

        $validated['deadline'] = $validated['application_deadline'] ?? null;
        unset($validated['application_deadline']);

        $validated['search_index'] = $request->boolean('search_index', false);
        $validated['currency'] = $validated['currency'] ?? 'VND';

        $job->update($validated);
        // Gửi thông báo cho tất cả admin
        User::where('role', 'admin')->get()->each(function ($admin) use ($job) {
            $admin->notify(new JobEditedNotification($job));
        });


        // Xử lý lưu kỹ năng
        if ($request->filled('skills_text')) {
            $skillNames = array_map('trim', explode(',', $request->input('skills_text')));
            $skillIds = Skill::whereIn('name', $skillNames)->pluck('id')->toArray();
            $job->skills()->sync($skillIds);
        } else {
            $job->skills()->detach();
        }

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
        $job = Job::with(['company', 'category'])->findOrFail($id);
        return view('employer.jobs.show', compact('job'));
    }
}
