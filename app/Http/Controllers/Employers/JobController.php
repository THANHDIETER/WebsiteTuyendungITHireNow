<?php

namespace App\Http\Controllers\Employers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Notifications\Admin\NewJobSubmittedNotification;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    // Danh sách job đã đăng
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->company) {
            return redirect()->route('employer.dashboard')->withErrors('Bạn chưa có thông tin công ty.');
        }

        $jobs = Job::where('company_id', $user->company->id)
            ->latest()
            ->paginate(10);

        return view('employer.jobs.index', compact('jobs'));
    }

    // Hiển thị form đăng tin
    public function create()
    {
        $categories = Category::all();
        return view('employer.jobs.create', compact('categories'));
    }

    // Xử lý lưu tin tuyển dụng (miễn phí 3, sau đó yêu cầu mua gói)
    public function store(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('employer.dashboard')
                ->withErrors('Bạn chưa có thông tin công ty.');
        }

        // ------ XỬ LÝ QUOTA FREE BAN ĐẦU ------
        // Nếu quota chưa từng được set hạn thì bắt đầu 7 ngày từ lần đăng đầu
        if (!$company->free_post_quota_expired_at) {
            $company->free_post_quota_expired_at = now()->addDays(7);
            $company->free_post_quota_used = 0;
            $company->save();
        }

        // Đã hết hạn quota free thì không cho đăng free nữa, phải mua gói mới (1 lần duy nhất)
        $freeQuotaStillValid = $company->free_post_quota_expired_at && now()->lt($company->free_post_quota_expired_at);

        $freeRemain = 0;
        if ($freeQuotaStillValid) {
            $freeRemain = max($company->free_post_quota - $company->free_post_quota_used, 0);
        }

        // Tính tổng quota còn lại (free còn hạn, package nếu có)
        $package = $company->activeEmployerPackage();
        $packageRemain = $package ? ($package->post_limit - $package->posts_used) : 0;
        $totalQuota = $freeRemain + $packageRemain;

        // Nếu hết quota thì chuyển qua trang mua gói và báo lỗi
        if ($totalQuota <= 0) {
            return redirect()->route('employer.packages.index')
                ->with('error', 'Bạn đã hết lượt đăng tin miễn phí hoặc gói dịch vụ. Vui lòng mua gói để tiếp tục đăng tin.');
        }

        // VALIDATE
        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'requirements'  => 'nullable|string',
            'benefits'      => 'nullable|string',
            'job_type'      => 'required|in:full-time,part-time,internship,remote,contract',
            'salary_min'    => 'nullable|numeric|min:0',
            'salary_max'    => 'nullable|numeric|min:0|gte:salary_min',
            'location'      => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'level'         => 'nullable|string|max:255',
            'experience'    => 'nullable|string|max:255',
            'category_id'   => 'required|integer|exists:categories,id',
            'deadline'      => 'nullable|date|after_or_equal:today',
            'apply_url'     => 'nullable|url',
            'remote_policy' => 'nullable|string|max:100',
            'language'      => 'nullable|string|max:50',
            'meta_title'    => 'nullable|string|max:150',
            'meta_description' => 'nullable|string',
            'search_index'  => 'nullable|boolean',
        ]);

        // Gán thêm các trường phụ
        $validated['search_index'] = $request->boolean('search_index', false);
        $validated['slug']        = Str::slug($validated['title']) . '-' . uniqid();
        $validated['company_id']  = $company->id;
        $validated['status']      = 'pending';
        $validated['is_approved'] = false;
        $validated['currency']    = 'VND';
        $validated['views']       = 0;
        $validated['is_featured'] = false;

        // --- Quyết định sử dụng lượt nào ---
        if ($freeRemain > 0) {
            $validated['is_paid'] = false; // Miễn phí
            $company->free_post_quota_used += 1;
            $company->save();
        } else if ($packageRemain > 0 && $package) {
            $validated['is_paid'] = true;
            $package->increment('posts_used');
        } else {
            // Lý thuyết không xảy ra
            return redirect()->route('employer.packages.index')
                ->with('error', 'Có lỗi xảy ra khi kiểm tra lượt đăng tin. Vui lòng thử lại hoặc liên hệ hỗ trợ.');
        }

        $job = Job::create($validated);

        // Gửi thông báo cho admin khi có job mới
        $admins = \App\Models\User::where('role', 'admin')->get();
        foreach ($admins as $admin) {
            $admin->notify(new NewJobSubmittedNotification($job));
        }

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Tin đã được gửi và đang chờ phê duyệt.');

    }
    public function edit($id)
    {
        $user = Auth::user();
        $company = $user->company;
        $job = $company->jobs()->where('id', $id)->firstOrFail();
        $categories = \App\Models\Category::all();
        return view('employer.jobs.edit', compact('job', 'categories'));
    }

    public function update(Request $request, $id)
    {
        $user = Auth::user();
        $company = $user->company;
        $job = $company->jobs()->where('id', $id)->firstOrFail();

        $validated = $request->validate([
            'title'         => 'required|string|max:255',
            'description'   => 'required|string',
            'requirements'  => 'nullable|string',
            'benefits'      => 'nullable|string',
            'job_type'      => 'required|in:full-time,part-time,internship,remote,contract',
            'salary_min'    => 'nullable|numeric|min:0',
            'salary_max'    => 'nullable|numeric|min:0|gte:salary_min',
            'location'      => 'nullable|string|max:255',
            'address'       => 'nullable|string|max:255',
            'level'         => 'nullable|string|max:255',
            'experience'    => 'nullable|string|max:255',
            'category_id'   => 'required|integer|exists:categories,id',
            'deadline'      => 'nullable|date|after_or_equal:today',
            'apply_url'     => 'nullable|url',
            'remote_policy' => 'nullable|string|max:100',
            'language'      => 'nullable|string|max:50',
            'meta_title'    => 'nullable|string|max:150',
            'meta_description' => 'nullable|string',
            'search_index'  => 'nullable|boolean',
        ]);

        $validated['search_index'] = $request->boolean('search_index', false);

        $job->update($validated);

        return redirect()->route('employer.jobs.show', $job->id)
            ->with('success', 'Cập nhật tin tuyển dụng thành công.');
    }

    public function show($id)
    {
        $job = Job::with(['company', 'category'])->findOrFail($id);
        return view('employer.jobs.show', compact('job'));
    }
}
