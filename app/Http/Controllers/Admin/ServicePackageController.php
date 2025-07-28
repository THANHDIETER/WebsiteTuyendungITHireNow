<?php
namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\EmployerPackage;
use App\Http\Controllers\Controller;

class ServicePackageController extends Controller
{
    public function index(Request $request)
    {
        $title = 'Danh sách gói dịch vụ';
        $query = EmployerPackage::query();
        if ($request->has('status') && $request->status !== '') {
            $query->where('is_active', $request->status);
        }
        $packages = $query->orderBy('sort_order')->paginate(10);
        return view('admin.service-packages.index', compact('packages', 'title'));
    }

    public function create()
    {
        return view('admin.service-packages.create');
    }

   

    public function show(EmployerPackage $service_package)
    {
        return view('admin.service-packages.show', compact('service_package'));
    }

    public function edit(EmployerPackage $service_package)
    {
        return view('admin.service-packages.edit', compact('service_package'));
    }

    public function update(Request $request, EmployerPackage $service_package)
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
        return response()->json(['success' => true, 'message' => 'Đã cập nhật gói dịch vụ.']);

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
        EmployerPackage::create($data);
        return response()->json(['success' => true, 'message' => 'Gói dịch vụ đã được tạo.']);
    }

    public function destroy($id)
    {
        $EmployerPackage = EmployerPackage::find($id);

        if (!$EmployerPackage) {
            return response()->json([
                'success' => false,
                'message' => 'Gói dịch vụ không tồn tại hoặc đã bị xoá.'
            ], 404);
        }

        $EmployerPackage->delete();

        return response()->json([
            'success' => true,
            'message' => 'Đã xoá gói dịch vụ thành công.'
        ]);
    }
}