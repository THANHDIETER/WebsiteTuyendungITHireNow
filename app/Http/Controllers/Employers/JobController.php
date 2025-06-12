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

        // Tổng quota còn lại
        $quotaRemain = $company->getPostingQuota();

        // Nếu hết lượt => yêu cầu mua gói, hiện thông báo rõ ràng
        if ($quotaRemain <= 0) {
            return redirect()->route('employer.packages.index')
                ->with('error', 'Bạn đã hết lượt đăng tin miễn phí. Vui lòng mua gói dịch vụ để đăng thêm tin.');
        }

        // Validate dữ liệu đầu vào
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

        // Xử lý trường boolean (checkbox)
        $validated['search_index'] = $request->boolean('search_index', false);
        $validated['slug']        = Str::slug($validated['title']) . '-' . uniqid();
        $validated['company_id']  = $company->id;
        $validated['status']      = 'pending';
        $validated['is_approved'] = false;
        $validated['currency']    = 'VND';
        $validated['views']       = 0;
        $validated['is_featured'] = false;

        // Phân loại miễn phí hay trả phí
        if ($company->getFreeQuotaRemain() > 0) {
            $validated['is_paid'] = false; // Tin miễn phí
        } else {
            $package = $company->activeEmployerPackage();
            if ($package) {
                $validated['is_paid'] = true; // Tin trả phí từ package
                $package->increment('posts_used');
            } else {
                // Dự phòng, không nên xảy ra vì đã check quota bên trên
                $validated['is_paid'] = true;
            }
        }

        Job::create($validated);

        return redirect()->route('employer.jobs.index')
            ->with('success', 'Tin đã được gửi và đang chờ phê duyệt.');
    }
    public function show($id)
{
    $job = Job::with(['company', 'category'])->findOrFail($id);
    return view('employer.jobs.show', compact('job'));
}

}
