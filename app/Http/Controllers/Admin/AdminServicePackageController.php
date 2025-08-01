<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class AdminServicePackageController extends Controller
{

    public function index(Request $request)
    {
        $query = ServicePackage::query();

        if ($request->has('status') && in_array($request->input('status'), ['active', 'inactive'])) {
            $query->where('status', $request->input('status'));
        }

        $packages = $query->get();
        return view('admin.service-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.service-packages.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        ServicePackage::create($validated);

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Gói dịch vụ đã được tạo thành công.');
    }

    public function edit(ServicePackage $servicePackage)
    {
        return view('admin.service-packages.edit', compact('servicePackage'));
    }

    public function update(Request $request, ServicePackage $servicePackage)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'price' => 'required|numeric|min:0',
            'duration_days' => 'required|integer|min:1',
            'features' => 'nullable|string',
            'status' => 'required|in:active,inactive',
        ]);

        $servicePackage->update($validated);

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Gói dịch vụ đã được cập nhật thành công.');
    }

    public function destroy(ServicePackage $servicePackage)
    {
        $servicePackage->delete();

        return redirect()->route('admin.service-packages.index')
            ->with('success', 'Gói dịch vụ đã bị xóa thành công.');
    }
}
