<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\CompanyBranch;
use App\Models\Location; // thêm vào
use Illuminate\Http\Request;

class CompanyBranchController extends Controller
{
    public function index($companyId)
    {
        $company = Company::with('branches.city')->findOrFail($companyId); 
        $locations = Location::all(); // lấy danh sách tỉnh/thành

        return view('employer.company_branches.index', compact('company', 'locations'));
    }

    public function create($companyId)
    {
        $company = Company::findOrFail($companyId);
        $locations = Location::all(); 

        return view('company_branches.create', compact('company','locations'));
    }

    public function store(Request $request, $companyId)
    {
        $company = Company::findOrFail($companyId);

        $data = $request->validate([
            'name'    => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city_id' => 'nullable|exists:locations,id',
            'phone'   => 'nullable|string|max:20',
        ]);

        $company->branches()->create($data);

        return redirect()->route('employer.company.branches.index', $companyId)
                         ->with('success', 'Thêm chi nhánh thành công!');
    }

    public function edit($companyId, $id)
    {
        $branch  = CompanyBranch::where('company_id', $companyId)->findOrFail($id);
        $company = Company::findOrFail($companyId);
        $locations = Location::all();

        return view('company_branches.edit', compact('branch', 'company','locations'));
    }

    public function update(Request $request, $companyId, $id)
    {
        $branch = CompanyBranch::where('company_id', $companyId)->findOrFail($id);

        $data = $request->validate([
            'name'    => 'nullable|string|max:255',
            'address' => 'required|string|max:255',
            'city_id' => 'nullable|exists:locations,id',
            'phone'   => 'nullable|string|max:20',
        ]);

        $branch->update($data);

        return redirect()->route('employer.company.branches.index', $companyId)
                         ->with('success', 'Cập nhật chi nhánh thành công!');
    }

    public function destroy($companyId, $id)
    {
        $branch = CompanyBranch::where('company_id', $companyId)->findOrFail($id);
        $branch->delete();

        return redirect()->route('employer.company.branches.index', $companyId)
                         ->with('success', 'Xóa chi nhánh thành công!');
    }
}
