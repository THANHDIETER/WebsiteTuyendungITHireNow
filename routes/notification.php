<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\NotificationController;

Route::middleware('job_seeker')->group(function () {
    // Trang danh sách thông báo
    Route::get('/notifications', [NotificationController::class, 'index'])
        ->name('notifications.index');

    // Đánh dấu 1 thông báo đã đọc
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
        ->name('notifications.read');

    // Đánh dấu tất cả đã đọc
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
        ->name('notifications.readAll');

    // ⬅️ JSON detail để client “resolve” message/link khi payload realtime thiếu
    Route::get('/notifications/{id}/json', [NotificationController::class, 'json'])
        ->name('notifications.json');
});
