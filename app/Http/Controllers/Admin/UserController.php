<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // Lấy danh sách user có phân trang & lọc theo role
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->has('role') && $request->role !== null && $request->role !== '') {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }


    // Xem chi tiết 1 user
    public function show($id)
    {
        $user = User::findOrFail($id);
        return response()->json($user);
    }

    // Cập nhật trạng thái block
    public function update(Request $request, $id)
    {
        $request->validate([
            'is_blocked' => 'required|boolean',
        ]);

        $user = User::findOrFail($id);
        $user->is_blocked = $request->is_blocked;
        $user->save();

        return response()->json(['message' => 'User block status updated successfully.']);
    }

    // Xóa user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
