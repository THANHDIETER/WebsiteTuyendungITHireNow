<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CompanyBranchController extends Controller
{
    public function index()
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $company->load('branches.city'); // eager load

        $locations = Location::all();

        return view('employer.branches.index', compact('company', 'locations'));
    }


    public function store(Request $request)
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city_id' => 'nullable|exists:locations,id',
            'phone' => 'nullable|string|max:20',
        ]);

        $company->branches()->create($data);

        return redirect()
            ->route('employer.branches.index')
            ->with('success', 'Thêm chi nhánh thành công!');
    }

    public function edit($id)
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $branch = CompanyBranch::where('company_id', $company->id)->findOrFail($id);

        $locations = Location::all();

        return view('employer.branches.edit', compact('branch', 'company', 'locations'));
    }


    public function update(Request $request, $id)
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $branch = CompanyBranch::where('company_id', $company->id)->findOrFail($id);

        $data = $request->validate([
            'name' => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city_id' => 'nullable|exists:locations,id',
            'phone' => 'nullable|string|max:20',
        ]);

        $branch->update($data);

        return redirect()
            ->route('employer.branches.index')
            ->with('success', 'Cập nhật chi nhánh thành công!');
    }


    public function destroy($id)
    {
        $company = Company::where('user_id', Auth::id())->firstOrFail();

        $branch = CompanyBranch::where('company_id', $company->id)->findOrFail($id);

        $branch->delete();

        return redirect()
            ->route('employer.branches.index')
            ->with('success', 'Xóa chi nhánh thành công!');
    }
}
