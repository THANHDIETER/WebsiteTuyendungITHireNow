<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;

class UserController extends Controller
{
    // 📄 Lấy danh sách user có phân trang & lọc theo role
    public function index(Request $request)
    {
        $query = User::query();

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        $users = $query->paginate(10);

        return view('admin.users.index', compact('users'));
    }

    // 👁️ Xem chi tiết 1 user
   public function show($id)
{
    $user = User::findOrFail($id);
    return view('admin.users.show', compact('user'));
}

    // ⚙️ Cập nhật trạng thái "status" (thay vì is_blocked)
    public function update(Request $request, $id)
    {
        $request->validate([
            'status' => 'required|in:active,inactive,blocked',
        ]);

        $user = User::findOrFail($id);
        $user->status = $request->status;
        $user->save();

        return response()->json(['message' => 'User status updated successfully.']);
    }

    // ❌ Xóa user
    public function destroy($id)
    {
        $user = User::findOrFail($id);
        $user->delete();

        return response()->json(['message' => 'User deleted successfully.']);
    }
}
