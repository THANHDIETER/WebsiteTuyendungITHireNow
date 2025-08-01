<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class EmployerController extends Controller
{
    // Danh sách nhà tuyển dụng
    public function index()
    {
        $employers = User::where('role', 'employer')->with('companies')->latest()->paginate(10);
        return view('admin.employers.index', compact('employers'));
    }

    // Trang tạo mới (nếu cần)
    public function create()
    {
        return view('admin.employers.create');
    }

    // Lưu mới (nếu cần)
    public function store(Request $request)
    {
        $validated = $request->validate([
            'email' => 'required|email|unique:users,email',
            'password' => 'required|min:6',
            'name' => 'required|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,banned',
            'is_blocked' => 'nullable|boolean',
        ]);

        $validated['role'] = 'employer';
        $validated['password'] = bcrypt($validated['password']);

        User::create($validated);

        return redirect()->route('admin.employers.index')->with('success', 'Thêm nhà tuyển dụng thành công.');
    }

    // Xem chi tiết nhà tuyển dụng
    public function show($id)
    {
        $employer = User::where('role', 'employer')->with('companies')->findOrFail($id);
        return view('admin.employers.show', compact('employer'));
    }

    // Form sửa (nếu dùng riêng)
    public function edit($id)
    {
        $employer = User::where('role', 'employer')->findOrFail($id);
        return view('admin.employers.edit', compact('employer'));
    }

    // Cập nhật
    public function update(Request $request, $id)
    {
        $employer = User::where('role', 'employer')->findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:100',
            'phone_number' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive,banned',
            'is_blocked' => 'nullable|boolean'
        ]);

        $employer->update($validated);

        return redirect()->route('admin.employers.index')->with('success', 'Cập nhật thành công.');
    }

    // Xóa mềm
    public function destroy($id)
    {
        $employer = User::where('role', 'employer')->findOrFail($id);
        $employer->delete();

        return redirect()->route('admin.employers.index')->with('success', 'Đã xóa nhà tuyển dụng.');
    }
}
