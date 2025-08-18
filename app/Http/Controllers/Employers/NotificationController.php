<?php

namespace App\Http\Controllers\Employers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(10);

        // Nếu muốn vào trang là mark all read, mở dòng dưới:
        // Auth::user()->unreadNotifications->markAsRead();

        return view('employer.notifications.index', compact('notifications'));
    }

    public function markAsRead(string $id, Request $request)
    {
        $notification = $request->user()
            ->notifications() // gồm cả đã đọc/chưa đọc
            ->where('id', $id)
            ->firstOrFail();

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'status'       => 'ok',
            'unread_count' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * ✅ Đánh dấu TẤT CẢ thông báo chưa đọc thành đã đọc (dùng cho nút "Đánh dấu tất cả đã đọc")
     */
    public function markAllAsRead(Request $request)
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'status'       => 'ok',
            'unread_count' => 0,
        ]);
    }

    /**
     * ✅ Trả JSON chi tiết 1 notification (fallback khi payload realtime thiếu message/link)
     */
    public function showJson(string $id, Request $request)
    {
        $noti = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        $data = (array) $noti->data;

        // Chuẩn hoá message
        $message = null;
        if (array_key_exists('message', $data)) {
            $message = is_string($data['message'])
                ? trim($data['message'])
                : json_encode($data['message'], JSON_UNESCAPED_UNICODE);
        }
        if (!$message || $message === '') {
            $message = $data['title'] ?? 'Có thông báo mới!';
        }

        // Chuẩn hoá link
        $link = (isset($data['link_url']) && is_string($data['link_url']) && trim($data['link_url']) !== '')
            ? $data['link_url']
            : '#';

        return response()->json([
            'id'         => $noti->id,
            'message'    => $message,
            'link_url'   => $link,
            'created_at' => optional($noti->created_at)->toIso8601String(),
            'read_at'    => optional($noti->read_at)->toIso8601String(),
        ]);
    }
}
