<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Notification;
use App\Models\User;
use App\Mail\SystemNotificationMail;
use Illuminate\Support\Facades\Mail;


class NotificationController extends Controller
{
    /**
     * Lấy danh sách các thông báo.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $query = Notification::query()->with('user');

        if ($request->status === 'read') {
            $query->where('is_read', true);
        } elseif ($request->status === 'unread') {
            $query->where('is_read', false);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $notifications = $query->orderByDesc('created_at')->paginate(10);
        $users = User::select('id', 'email')->get(); // 👈 dòng cần thêm

        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    public function show($id)
    {
        $notification = Notification::with('user')->findOrFail($id);
        return view('admin.notifications.show', compact('notification'));
    }
    public function create()
    {
        $users = User::select('id', 'email')->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function edit($id)
    {
        $notification = Notification::findOrFail($id);
        $users = User::select('id', 'email')->get();
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|string|max:50',
            'message' => 'required|string',
            'link_url' => 'nullable|string|max:255',
            'user_id' => 'nullable|exists:users,id',
        ]);

        $notification = Notification::findOrFail($id);

        $notification->update([
            'type' => $request->type,
            'message' => $request->message,
            'link_url' => $request->link_url,
            'user_id' => $request->user_id !== 'all' ? $request->user_id : null,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Thông báo đã được cập nhật.');
    }

    public function destroy($id)
    {
        $notification = Notification::findOrFail($id);
        $notification->delete();
        
        return response()->json(['message' => 'Bạn đã xóa thành công.']); 
    }

    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|string|max:50',
            'message' => 'required|string',
            'link_url' => 'nullable|string|max:255',
            'user_id' => 'nullable',
        ]);

        if ($request->user_id === 'all') {
            $users = User::all();
            foreach ($users as $user) {
                Notification::create([
                    'user_id' => $user->id,
                    'type' => $request->type,
                    'message' => $request->message,
                    'link_url' => $request->link_url,
                ]);
                Mail::to($user->email)->send(new SystemNotificationMail($request->message, $request->link_url));
            }
        } else {
            $user = User::findOrFail($request->user_id);
            Notification::create([
                'user_id' => $user->id,
                'type' => $request->type,
                'message' => $request->message,
                'link_url' => $request->link_url,
            ]);
            Mail::to($user->email)->send(new SystemNotificationMail($request->message, $request->link_url));
        }

        return redirect()->route('admin.notifications.index')->with('success', 'Đã gửi thông báo thành công!');
    }
}
