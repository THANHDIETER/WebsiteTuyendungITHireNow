<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServicePackage;
use Illuminate\Http\Request;

class ServicePackageController extends Controller
{
    public function index(Request $request)
    {
        $query = ServicePackage::query();
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        $packages = $query->orderBy('sort_order')->paginate(10);
        return view('admin.service-packages.index', compact('packages'));
    }

    public function create()
    {
        return view('admin.service-packages.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'post_limit' => 'required|integer|min:1',
            'highlight_days' => 'nullable|integer|min:0',
            'cv_view_limit' => 'nullable|integer|min:0',
            'support_level' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        ServicePackage::create($data);
        return redirect()->route('admin.service-packages.index')->with('success', 'Gói dịch vụ đã được tạo.');
    }

    public function show(ServicePackage $service_package)
    {
        return view('admin.service-packages.show', compact('service_package'));
    }

    public function edit(ServicePackage $service_package)
    {
        return view('admin.service-packages.edit', compact('service_package'));
    }

    public function update(Request $request, ServicePackage $service_package)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'description' => 'nullable|string',
            'price' => 'required|integer|min:0',
            'duration_days' => 'required|integer|min:1',
            'post_limit' => 'required|integer|min:1',
            'highlight_days' => 'nullable|integer|min:0',
            'cv_view_limit' => 'nullable|integer|min:0',
            'support_level' => 'nullable|string|max:50',
            'sort_order' => 'nullable|integer',
        ]);
        $data['is_active'] = $request->has('is_active');
        $service_package->update($data);
        return redirect()->route('admin.service-packages.index')->with('success', 'Đã cập nhật gói dịch vụ.');
    }

    public function destroy(ServicePackage $service_package)
    {
        $service_package->delete();
        return back()->with('success', 'Đã xoá gói dịch vụ.');
    }
}