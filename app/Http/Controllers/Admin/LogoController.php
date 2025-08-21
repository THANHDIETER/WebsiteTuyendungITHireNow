<?php
namespace App\Http\Controllers\Admin;
use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    // 👉 Hiển thị trang index với toàn bộ logo (dùng để update trực tiếp)
    public function index()
    {
        $title = 'Quản lý logo';
        $logos = Logo::all();   // lấy tất cả logo trong DB
        return view('admin.logo.index', compact('logos', 'title'));
    }

    // 👉 Update từng logo theo type
    public function updateSingle(Request $request, $type)
    {
        $request->validate([
            'image' => 'required|image|max:2048',
        ]);

        $logo = Logo::where('type', $type)->first();

        if (!$logo) {
            $logo = new Logo();
            $logo->type = $type;
        }

        // Xóa ảnh cũ
        if ($logo->image_path && Storage::disk('public')->exists($logo->image_path)) {
            Storage::disk('public')->delete($logo->image_path);
        }

        // Upload ảnh mới
        $path = $request->file('image')->store('logos', 'public');
        $logo->image_path = $path;
        $logo->is_active = 1;
        $logo->save();

        return back()->with('success', "Cập nhật logo {$type} thành công!");
    }
    public function updateAll(Request $request)
    {
        $request->validate([
            'logos.*' => 'nullable|mimes:jpeg,png,jpg,gif,svg,webp|max:5048',
        ]);

        foreach ($request->file('logos', []) as $type => $file) {
            if ($file) {
                $logo = Logo::firstOrNew(['type' => $type]);

                // Xóa ảnh cũ
                if ($logo->image_path && Storage::disk('public')->exists($logo->image_path)) {
                    Storage::disk('public')->delete($logo->image_path);
                }

                // Upload ảnh mới
                $path = $file->store('logos', 'public');
                $logo->image_path = $path;
                $logo->is_active = 1;
                $logo->save();
            }
        }

        return back()->with('success', 'Cập nhật toàn bộ logo thành công!');
    }
}
