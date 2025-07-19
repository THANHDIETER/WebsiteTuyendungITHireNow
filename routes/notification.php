<?php

use Illuminate\Support\Facades\Route;

// Nhóm route thông báo, yêu cầu user đã đăng nhập
Route::middleware(['auth'])->group(function () {

    // 🛡️ Admin notification route
    Route::get('/admin/noti/latest', function () {
        $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

        return response()->json($notifications->map(function ($noti) {
            return [
                'id' => $noti->id,
                'message' => $noti->data['message'],
                'link_url' => $noti->data['link_url'],
                'time' => $noti->created_at->diffForHumans()
            ];
        }));
    })->name('admin.notifications.latest');

    // 🏢 Employer notification route
    Route::get('/employer/noti/latest', function () {
        $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

        return response()->json($notifications->map(function ($noti) {
            return [
                'id' => $noti->id,
                'message' => $noti->data['message'],
                'link_url' => $noti->data['link_url'],
                'time' => $noti->created_at->diffForHumans()
            ];
        }));
    })->name('employer.notifications.latest');

    // 🙋 Job Seeker notification route
    Route::get('/seeker/notifications/latest', function () {
        $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

        return response()->json($notifications->map(function ($noti) {
            return [
                'id' => $noti->id,
                'message' => $noti->data['message'],
                'link_url' => $noti->data['link_url'],
                'time' => $noti->created_at->diffForHumans(),
            ];
        }));
    })->name('seeker.notifications.latest');

});
