<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Logo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LogoController extends Controller
{
    public function index()
    {
        $logos = Logo::latest()->paginate(10);
        return view('admin.logo.index', compact('logos'));
    }

    public function create()
    {
        $types = ['site', 'header', 'footer', 'client', 'admin'];
        return view('admin.logo.create', compact('types'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'  => 'nullable|string|max:255',
            'type'  => 'required|in:site,header,footer,client,admin',
            'image' => 'required|image|max:2048',
        ]);

        // Nếu có check "kích hoạt", thì tắt các logo khác cùng loại
        if ($request->has('is_active')) {
            Logo::where('type', $request->type)->update(['is_active' => false]);
        }

        $path = $request->file('image')->store('logos', 'public');

        Logo::create([
            'name'       => $request->name,
            'type'       => $request->type,
            'image_path' => $path,
            'is_active'  => $request->has('is_active'),
        ]);

        return redirect()->route('admin.logos.index')->with('success', 'Thêm logo thành công!');
    }
    public function edit(Logo $logo)
    {
        $types = ['site', 'header', 'footer', 'client', 'admin'];
        return view('admin.logo.edit', compact('logo', 'types'));
    }

    public function update(Request $request, Logo $logo)
    {
        $request->validate([
            'name'  => 'nullable|string|max:255',
            'type'  => 'required|in:site,header,footer,client,admin',
            'image' => 'nullable|image|max:2048',
        ]);

        if ($request->has('is_active')) {
            Logo::where('type', $request->type)
                ->where('id', '!=', $logo->id)
                ->update(['is_active' => false]);
        }

        $data = $request->only(['name', 'type']);
        $data['is_active'] = $request->has('is_active');

        if ($request->hasFile('image')) {
            // Xoá ảnh cũ nếu có
            if ($logo->image_path && \Storage::disk('public')->exists($logo->image_path)) {
                \Storage::disk('public')->delete($logo->image_path);
            }
            $data['image_path'] = $request->file('image')->store('logos', 'public');
        }

        $logo->update($data);

        return redirect()->route('admin.logos.index')->with('success', 'Cập nhật logo thành công!');
    }

    public function destroy(Logo $logo)
    {
        // Xoá file ảnh
        if ($logo->image_path && Storage::disk('public')->exists($logo->image_path)) {
            Storage::disk('public')->delete($logo->image_path);
        }

        $logo->delete();

        return back()->with('success', 'Xóa logo thành công!');
    }
}
