<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class CompanyController extends Controller
{
    /**
     * Danh sách công ty của user hiện tại.
     */
    public function index()
    {
        $companies = Company::with('user')
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->paginate(10);

        return view('employer.companies.index', compact('companies'));
    }

    /**
     * Trang chi tiết công ty (thuần ID).
     */
    public function show($id)
    {
        $company = Company::with('user')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        // Nếu cần jobs thì lấy theo company_id (KHÔNG dùng Job::findOrFail($id))
        // $jobs = Job::where('company_id', $company->id)->latest()->paginate(10);

        return view('employer.companies.show', compact('company'));
    }

    /**
     * Form tạo mới.
     */
    public function create()
    {
        return view('employer.companies.create');
    }

    /**
     * Lưu công ty mới.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'website'        => 'nullable|url|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:500',
            'city'           => 'nullable|string|max:255',
            'company_size'   => 'nullable|string|max:255',
            'founded_year'   => 'nullable|integer|min:1900|max:' . date('Y'),
            'industry'       => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:3000',
            'benefits'       => 'nullable|string|max:3000',
            'status'         => 'nullable|in:active,inactive,banned',
            'free_post_quota'=> 'nullable|integer|min:0',
            'free_post_quota_expired_at' => 'nullable|date',
            'free_post_quota_used'       => 'nullable|integer|min:0',
            // file upload
            'logo'           => 'nullable|image|max:5120',
            'cover_image'    => 'nullable|image|max:5120',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::id();
        // Nếu bạn cần slug cho nơi khác, vẫn có thể tạo nhưng route dùng ID nên không phụ thuộc slug
        $data['slug'] = Str::slug($data['name']) . '-' . uniqid();

        if ($request->hasFile('logo')) {
            $data['logo_url'] = $request->file('logo')->store('companies/logos', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $data['cover_image_url'] = $request->file('cover_image')->store('companies/covers', 'public');
        }

        Company::create($data);

        return redirect()
            ->route('employer.companies.index')
            ->with('toast_success', 'Tạo công ty thành công.');
    }

    /**
     * Form sửa.
     */
    public function edit($id)
    {
        $company = Company::where('user_id', Auth::id())->findOrFail($id);
        return view('employer.companies.edit', compact('company'));
    }

    /**
     * Cập nhật công ty.
     */
    public function update(Request $request, $id)
    {
        $company = Company::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:255',
            'website'        => 'nullable|url|max:255',
            'email'          => 'nullable|email|max:255',
            'phone'          => 'nullable|string|max:20',
            'address'        => 'nullable|string|max:500',
            'city'           => 'nullable|string|max:255',
            'company_size'   => 'nullable|string|max:255',
            'founded_year'   => 'nullable|integer|min:1900|max:' . date('Y'),
            'industry'       => 'nullable|string|max:255',
            'description'    => 'nullable|string|max:3000',
            'benefits'       => 'nullable|string|max:3000',
            'status'         => 'nullable|in:active,inactive,banned',
            // file upload
            'logo'           => 'nullable|image|max:5120',
            'cover_image'    => 'nullable|image|max:5120',
        ]);

        // Không thay slug để URL/SEO (nếu bạn có dùng) ổn định
        $company->fill([
            'name'         => $validated['name'],
            'website'      => $validated['website'] ?? null,
            'email'        => $validated['email'] ?? null,
            'phone'        => $validated['phone'] ?? null,
            'address'      => $validated['address'] ?? null,
            'city'         => $validated['city'] ?? null,
            'company_size' => $validated['company_size'] ?? null,
            'founded_year' => $validated['founded_year'] ?? null,
            'industry'     => $validated['industry'] ?? null,
            'description'  => $validated['description'] ?? null,
            'benefits'     => $validated['benefits'] ?? null,
            'status'       => $validated['status'] ?? 'inactive',
        ]);

        if ($request->hasFile('logo')) {
            if ($company->logo_url) {
                Storage::disk('public')->delete($company->logo_url);
            }
            $company->logo_url = $request->file('logo')->store('companies/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($company->cover_image_url) {
                Storage::disk('public')->delete($company->cover_image_url);
            }
            $company->cover_image_url = $request->file('cover_image')->store('companies/covers', 'public');
        }

        $company->save();

        return redirect()
            ->route('employer.companies.show', $company->id)
            ->with('toast_success', 'Cập nhật công ty thành công.');
    }

    /**
     * Xóa công ty.
     */
    public function destroy($id)
    {
        $company = Company::where('user_id', Auth::id())->findOrFail($id);
        $name = $company->name;

        // (Tùy chọn) Xóa file kèm theo
        if ($company->logo_url) {
            Storage::disk('public')->delete($company->logo_url);
        }
        if ($company->cover_image_url) {
            Storage::disk('public')->delete($company->cover_image_url);
        }

        $company->delete();

        return redirect()
            ->route('employer.companies.index')
            ->with('toast_success', "Công ty “{$name}” đã được xóa thành công.");
    }
}
