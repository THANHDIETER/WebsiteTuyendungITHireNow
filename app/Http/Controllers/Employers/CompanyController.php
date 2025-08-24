<?php

namespace App\Http\Controllers\Employers;

use App\Models\Company;
use App\Models\Location;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class CompanyController extends Controller
{
    public function index()
    {
        $companies = Company::with('user', 'city') // thêm quan hệ city
            ->where('user_id', Auth::id())
            ->latest('created_at')
            ->paginate(10);

        return view('employer.companies.index', compact('companies'));
    }

    public function show($id)
    {
        $company = Company::with('user', 'city')
            ->where('user_id', Auth::id())
            ->findOrFail($id);

        return view('employer.companies.show', compact('company'));
    }

    public function create()
    {
        $locations = Location::all();
        return view('employer.companies.create', compact('locations'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'website'      => 'nullable|url|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:500',
            'city_id'      => 'nullable|exists:locations,id',
            'company_size' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'industry'     => 'nullable|string|max:255',
            'description'  => 'nullable|string|max:3000',
            'benefits'     => 'nullable|string|max:3000',
            'status'       => 'nullable|in:active,inactive,banned',
            'logo'         => 'nullable|image|max:5120',
            'cover_image'  => 'nullable|image|max:5120',
        ]);

        $data = $validated;
        $data['user_id'] = Auth::id();
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

    public function edit($id)
    {
        $company   = Company::where('user_id', Auth::id())->findOrFail($id);
        $locations = Location::all();
        return view('employer.companies.edit', compact('company', 'locations'));
    }

    public function update(Request $request, $id)
    {
        $company = Company::where('user_id', Auth::id())->findOrFail($id);

        $validated = $request->validate([
            'name'         => 'required|string|max:255',
            'website'      => 'nullable|url|max:255',
            'email'        => 'nullable|email|max:255',
            'phone'        => 'nullable|string|max:20',
            'address'      => 'nullable|string|max:500',
            'city_id'      => 'nullable|exists:locations,id',
            'company_size' => 'nullable|string|max:255',
            'founded_year' => 'nullable|integer|min:1900|max:' . date('Y'),
            'industry'     => 'nullable|string|max:255',
            'description'  => 'nullable|string|max:3000',
            'benefits'     => 'nullable|string|max:3000',
            'status'       => 'nullable|in:active,inactive,banned',
            'logo'         => 'nullable|image|max:5120',
            'cover_image'  => 'nullable|image|max:5120',
        ]);

        $company->fill($validated);

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

    public function destroy($id)
    {
        $company = Company::where('user_id', Auth::id())->findOrFail($id);
        $name    = $company->name;

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
