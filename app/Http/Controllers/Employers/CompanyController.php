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
     * Hiển thị danh sách công ty.
     */
    public function index()
    {
        $companies = Company::with('user')
            ->where('user_id', auth()->id())
            ->latest('created_at')
            ->paginate(10);

        return view('employer.companies.index', compact('companies'));
    }


    /**
     * Hiển thị chi tiết một công ty.
     */
    public function show($id)
    {
        $company = Company::with('user')->findOrFail($id);
        return view('employer.companies.show', compact('company'));
    }

    /**
     * Hiển thị form sửa thông tin công ty.
     */
    public function edit($id)
    {
        $company = Company::findOrFail($id);
        return view('employer.companies.edit', compact('company'));
    }

    /**
     * Hiển thị form TẠO MỚI công ty.
     */
    public function create()
    {
        return view('employer.companies.create');
    }

    /**
     * Xử lý lưu công ty mới.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'slug' => 'nullable|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'logo_url' => 'nullable|string|max:255',
            'cover_image_url' => 'nullable|string|max:5020',
            'city' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'industry' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:3000',
            'benefits' => 'nullable|string|max:3000',
            'is_active' => 'nullable|boolean',
            'status' => 'nullable|string|max:255',
            'free_post_quota' => 'nullable|integer|min:0',
            'free_post_quota_expired_at' => 'nullable|date',
            'free_post_quota_used' => 'nullable|integer|min:0',
        ]);

        $validated['user_id'] = Auth::id();
        $validated['slug'] = Str::slug($validated['name']) . '-' . uniqid();

        if ($request->hasFile('logo')) {
            $validated['logo_url'] = $request->file('logo')
                ->store('companies/logos', 'public');
        }
        if ($request->hasFile('cover_image')) {
            $validated['cover_image_url'] = $request->file('cover_image')
                ->store('companies/covers', 'public');
        }

        Company::create($validated);

        return redirect()
            ->route('employer.companies.index')
            ->with('toast_success', 'Tạo công ty thành công.');
    }

    /**
     * Xử lý lưu thông tin công ty sau khi sửa.
     */
    public function update(Request $request, $id)
    {
        $company = Company::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'website' => 'nullable|url|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:255',
            'company_size' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'industry' => 'nullable|string|max:255',
            'description' => 'nullable|string|max:3000',
            'benefits' => 'nullable|string|max:3000',
            'status' => 'nullable|in:active,inactive,banned',
            'logo' => 'nullable|image|max:5020',
            'cover_image' => 'nullable|image|max:5020',
        ]);

        // Cập nhật các trường thường
        $company->fill([
            'name' => $validated['name'],
            'slug' => Str::slug($validated['name']),
            'website' => $validated['website'] ?? null,
            'email' => $validated['email'] ?? null,
            'phone' => $validated['phone'] ?? null,
            'address' => $validated['address'] ?? null,
            'city' => $validated['city'] ?? null,
            'company_size' => $validated['company_size'] ?? null,
            'founded_year' => $validated['founded_year'] ?? null,
            'industry' => $validated['industry'] ?? null,
            'description' => $validated['description'] ?? null,
            'benefits' => $validated['benefits'] ?? null,
            'status' => $validated['status'] ?? 'inactive',
        ]);

        if ($request->hasFile('logo')) {
            Storage::disk('public')->delete($company->logo_url);
            $company->logo_url = $request->file('logo')
                ->store('companies/logos', 'public');
        }

        if ($request->hasFile('cover_image')) {
            Storage::disk('public')->delete($company->cover_image_url);
            $company->cover_image_url = $request->file('cover_image')
                ->store('companies/covers', 'public');
        }

        $company->save();

        return redirect()
            ->route('employer.companies.show', $company->id)
            ->with('toast_success', 'Cập nhật công ty thành công.');
    }

    /**
     * Xóa một công ty.
     */
    public function destroy($id)
    {
        $company = Company::findOrFail($id);
        $name = $company->name;
        $company->delete();

        return redirect()
            ->route('employer.companies.index')
            ->with('toast_success', "Công ty “{$name}” đã được xóa thành công.");
    }
}