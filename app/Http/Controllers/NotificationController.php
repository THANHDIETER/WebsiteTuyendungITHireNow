<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\JsonResponse;

class NotificationController extends Controller
{
    /**
     * Trang danh sách thông báo
     */
    public function index(Request $request)
    {
        $notifications = Auth::user()
            ->notifications()
            ->latest()
            ->paginate(10);

        return view('website.notifications.index', compact('notifications'));
    }

    /**
     * Đánh dấu một thông báo đã đọc
     */
    public function markAsRead(string $id, Request $request): JsonResponse
    {
        $notification = $request->user()
            ->notifications()
            ->where('id', $id)
            ->firstOrFail();

        if (!$notification->read_at) {
            $notification->markAsRead();
        }

        return response()->json([
            'status' => 'ok',
            'unread_count' => $request->user()->unreadNotifications()->count(),
        ]);
    }

    /**
     * Đánh dấu tất cả thông báo chưa đọc thành đã đọc
     */
    public function markAllAsRead(Request $request): JsonResponse
    {
        $request->user()->unreadNotifications->markAsRead();

        return response()->json([
            'status' => 'ok',
            'unread_count' => 0,
        ]);
    }

    /**
     * ⬅️ Trả JSON chi tiết 1 notification để client fill nội dung/link ngay
     */
    public function json(string $id, Request $request): JsonResponse
    {
        $noti = $request->user()->notifications()->findOrFail($id);
        $data = $noti->data ?? [];

        $message = is_string(data_get($data, 'message'))
            ? data_get($data, 'message')
            : (data_get($data, 'title') ?: '');

        $link = data_get($data, 'link_url', '#');

        return response()->json([
            'id' => $noti->id,
            'message' => $message,
            'link_url' => $link,
            'read_at' => $noti->read_at,
            'created_at' => optional($noti->created_at)->diffForHumans(),
        ]);
    }
    public function latest()
    {
        $notis = auth()->user()
            ->unreadNotifications()
            ->orderBy('created_at', 'desc')
            ->take(6)
            ->get()
            ->map(function ($noti) {
                return [
                    'id' => $noti->id,
                    'message' => $noti->data['message'] ?? '',
                    'link_url' => $noti->data['link_url'] ?? '#',
                    'created_at' => $noti->created_at->diffForHumans(),
                ];
            });

        return response()->json($notis);
    }

}
