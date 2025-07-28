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
        $logos = Logo::latest()->paginate(10); // <= sửa ở đây
        return view('admin.logo.index', compact('logos'));
    }


    public function create()
    {
        return view('admin.logo.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'type' => 'required|string|max:100',
            'image' => 'required|image|max:2048',
        ]);

        $path = $request->file('image')->store('logos', 'public');

        Logo::create([
            'name' => $request->name,
            'type' => $request->type,
            'image_path' => $path,
            'is_active' => $request->has('is_active'),
        ]);

        return redirect()->route('admin.logos.index')->with('success', 'Thêm logo thành công!');
    }

    public function destroy(Logo $logo)
    {
        if ($logo->image_path) {
            Storage::disk('public')->delete($logo->image_path);
        }

        $logo->delete();
        return back()->with('success', 'Xóa logo thành công!');
    }
}
