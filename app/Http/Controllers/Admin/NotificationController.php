<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use Illuminate\Support\Str;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Notification::orderByDesc('created_at')->paginate(10);
        return view('admin.notifications.index', compact('notifications'));
    }

    // Lấy dữ liệu JSON cho modal
    public function getJson($id)
    {
        $n = Notification::findOrFail($id);
        return response()->json([
            'id' => $n->id,
            'type' => $n->type,
            'data' => $n->data,
            'read_at' => $n->read_at ? $n->read_at->format('d/m/Y H:i') : null,
            'created_at' => $n->created_at->format('d/m/Y H:i'),
        ]);
    }

    public function create()
    {
        return view('admin.notifications.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'data' => 'required|json',
        ]);

        Notification::create([
            'id' => Str::uuid(),
            'type' => $request->type,
            'notifiable_type' => 'system',
            'notifiable_id' => 0,
            'data' => json_decode($request->data, true),
            'read_at' => null,
        ]);

        return response()->json(['message' => 'Thêm thông báo thành công']);
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        return view('admin.notifications.edit', compact('notification'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:255',
            'data' => 'required|json',
        ]);

        $n = Notification::findOrFail($id);
        $n->update([
            'type' => $request->type,
            'data' => json_decode($request->data, true),
        ]);

        return response()->json(['message' => 'Cập nhật thành công']);
    }

    public function destroy($id)
    {
        Notification::findOrFail($id)->delete();
        return response()->json(['message' => 'Xóa thành công']);
    }

    
}