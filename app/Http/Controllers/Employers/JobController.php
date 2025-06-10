<?php

namespace App\Http\Controllers\Employers;

use App\Models\Job;
use App\Models\Category;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class JobController extends Controller
{
    /**
     * Danh sách tin tuyển dụng của nhà tuyển dụng
     */
    public function index()
    {
        $user = Auth::user();

        if (!$user || !$user->company) {
            return redirect()->route('employer.dashboard')->withErrors('Bạn chưa có thông tin công ty.');
        }

        $jobs = Job::where('company_id', $user->company->id)
            ->latest()
            ->paginate(10);

        return view('website.employers.jobs.index', compact('jobs'));
    }

    /**
     * Hiển thị form tạo tin tuyển dụng mới
     */
    public function create()
    {
        $categories = Category::all();
        return view('website.employers.jobs.create', compact('categories'));
    }

    /**
     * Xử lý lưu tin tuyển dụng (giới hạn 3 tin miễn phí)
     */
    public function store(Request $request)
    {
        $user = Auth::user();
        $company = $user->company;

        if (!$company) {
            return redirect()->route('employer.dashboard')->withErrors('Bạn chưa có thông tin công ty.');
        }

        // Đếm số tin đã đăng
        $currentJobCount = Job::where('company_id', $company->id)
            ->whereNull('deleted_at')
            ->count();

        if ($currentJobCount >= 3) {
            return redirect()->back()->with('error', 'Bạn đã đăng đủ 3 tin miễn phí. Vui lòng nâng cấp gói.');
        }

        $validated = $request->validate([
            'title'            => 'required|string|max:255',
            'description'      => 'required|string',
            'requirements'     => 'nullable|string',
            'benefits'         => 'nullable|string',
            'job_type'         => 'required|in:full-time,part-time,internship,remote,contract',
            'salary_min'       => 'nullable|integer',
            'salary_max'       => 'nullable|integer',
            'location'         => 'nullable|string|max:255',
            'address'          => 'nullable|string|max:255',
            'level'            => 'nullable|string|max:255',
            'experience'       => 'nullable|string|max:255',
            'category_id'      => 'required|integer|exists:categories,id',
            'deadline'         => 'nullable|date',

            // Bổ sung các trường còn thiếu:
            'apply_url'        => 'nullable|url',
            'remote_policy'    => 'nullable|string|max:100',
            'language'         => 'nullable|string|max:50',
            'meta_title'       => 'nullable|string|max:150',
            'meta_description' => 'nullable|string',
            'search_index'     => 'nullable|boolean',
        ]);

        // Xử lý field boolean từ checkbox
        $validated['search_index'] = $request->boolean('search_index', false);

        // Fill thông tin bắt buộc
        $validated['slug']        = Str::slug($validated['title']) . '-' . uniqid();
        $validated['company_id']  = $company->id;
        $validated['status']      = 'pending';
        $validated['is_approved'] = false;
        $validated['currency']    = 'VND';
        $validated['views']       = 0;
        $validated['is_featured'] = false;

        Job::create($validated);

        // Đổi route đúng tên nếu bạn đặt lại route, VD:
        return redirect()->route('employer.jobs.index')->with('success', 'Tin đã được gửi và đang chờ phê duyệt.');
    }
}
