<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Model thông báo hệ thống riêng của bạn
use App\Models\Notification as SystemNotification;
use App\Models\User;
use App\Mail\SystemNotificationMail;
use Illuminate\Support\Facades\Mail;

// Laravel auth + DB notification
use Illuminate\Support\Facades\Auth;
use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    // ===== CRUD cho thông báo hệ thống (model riêng) =====

    public function index(Request $request)
    {
        $query = SystemNotification::query()->with('user');

        if ($request->status === 'read') {
            $query->where('is_read', true);
        } elseif ($request->status === 'unread') {
            $query->where('is_read', false);
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->user_id);
        }

        $notifications = $query->orderByDesc('created_at')->paginate(10);
        $users = User::select('id', 'email')->get();

        return view('admin.notifications.index', compact('notifications', 'users'));
    }

    public function show($id)
    {
        $notification = SystemNotification::with('user')->findOrFail($id);
        return view('admin.notifications.show', compact('notification'));
    }

    public function create()
    {
        $users = User::select('id', 'email')->get();
        return view('admin.notifications.create', compact('users'));
    }

    public function edit($id)
    {
        $notification = SystemNotification::findOrFail($id);
        $users = User::select('id', 'email')->get();
        return view('admin.notifications.edit', compact('notification', 'users'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type'     => 'required|string|max:50',
            'message'  => 'required|string',
            'link_url' => 'nullable|string|max:255',
            'user_id'  => 'nullable|exists:users,id',
        ]);

        $notification = SystemNotification::findOrFail($id);

        $notification->update([
            'type'     => $request->type,
            'message'  => $request->message,
            'link_url' => $request->link_url,
            'user_id'  => $request->user_id !== 'all' ? $request->user_id : null,
        ]);

        return redirect()->route('admin.notifications.index')->with('success', 'Thông báo đã được cập nhật.');
    }

    public function destroy($id)
    {
        $notification = SystemNotification::findOrFail($id);
        $notification->delete();

        return response()->json(['message' => 'Bạn đã xóa thành công.']);
    }

    public function store(Request $request)
    {
        $request->validate([
            'type'     => 'required|string|max:50',
            'message'  => 'required|string',
            'link_url' => 'nullable|string|max:255',
            'user_id'  => 'nullable',
        ]);

        if ($request->user_id === 'all') {
            $users = User::all();
            foreach ($users as $user) {
                SystemNotification::create([
                    'user_id' => $user->id,
                    'type'    => $request->type,
                    'message' => $request->message,
                    'link_url' => $request->link_url,
                ]);
                Mail::to($user->email)->send(new SystemNotificationMail($request->message, $request->link_url));
            }
        } else {
            $user = User::findOrFail($request->user_id);
            SystemNotification::create([
                'user_id' => $user->id,
                'type'    => $request->type,
                'message' => $request->message,
                'link_url' => $request->link_url,
            ]);
            Mail::to($user->email)->send(new SystemNotificationMail($request->message, $request->link_url));
        }

        return redirect()->route('admin.notifications.index')->with('success', 'Đã gửi thông báo thành công!');
    }

    // ===== DatabaseNotification (realtime dropdown) =====

    /**
     * Đánh dấu 1 Laravel DatabaseNotification là đã đọc (dropdown click).
     */
    public function markRead(string $id): JsonResponse
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        /** @var DatabaseNotification|null $noti */
        $noti = $user->notifications()->where('id', $id)->first();

        if (!$noti) {
            return response()->json(['success' => false, 'message' => 'Notification not found'], 404);
        }

        if (is_null($noti->read_at)) {
            $noti->markAsRead();
        }

        return response()->json([
            'success'      => true,
            'unread_count' => $user->unreadNotifications()->count(), // để cập nhật badge đúng
        ]);
    }

    /**
     * Đánh dấu TẤT CẢ DatabaseNotification của user hiện tại là đã đọc.
     * Dùng cho nút "Đánh dấu tất cả đã đọc" ở dropdown.
     */
    public function markAllRead(): JsonResponse
    {
        /** @var \App\Models\User|null $user */
        $user = Auth::user();
        if (!$user) {
            return response()->json(['success' => false, 'message' => 'Unauthenticated'], 401);
        }

        $user->unreadNotifications->markAsRead();

        return response()->json([
            'success'      => true,
            'unread_count' => 0,
        ]);
    }

    /**
     * Trả JSON chi tiết cho 1 DatabaseNotification (fallback khi payload realtime thiếu).
     */
    public function json(string $id, Request $request): JsonResponse
    {
        /** @var \App\Models\User|null $user */
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Unauthenticated'], 401);
        }

        /** @var DatabaseNotification|null $noti */
        $noti = $user->notifications()->where('id', $id)->first();
        if (!$noti) {
            return response()->json(['message' => 'Notification not found'], 404);
        }

        $data = $noti->data ?? [];

        // Chuẩn hoá message giống ngoài view/dropdown
        $rawMessage = data_get($data, 'message');
        if (is_string($rawMessage) && trim($rawMessage) !== '') {
            $message = $rawMessage;
        } elseif (!is_null($rawMessage)) {
            // Nếu message là array/object => stringify (Unicode giữ nguyên)
            $message = json_encode($rawMessage, JSON_UNESCAPED_UNICODE);
        } else {
            $message = data_get($data, 'title') ?: 'Bạn có thông báo mới!';
        }

        $link = data_get($data, 'link_url');
        $link = (is_string($link) && trim($link) !== '') ? $link : '#';

        return response()->json([
            'id'         => $noti->id,
            'type'       => data_get($data, 'type'),
            'message'    => $message,
            'link_url'   => $link,
            'read_at'    => optional($noti->read_at)->toIso8601String(),
            'created_at' => optional($noti->created_at)->toIso8601String(),
        ]);
    }
}
