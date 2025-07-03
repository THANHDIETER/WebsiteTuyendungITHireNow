<?php
use Illuminate\Support\Facades\Broadcast;
Broadcast::routes(['middleware' => ['auth']]);

// Channel tùy chỉnh riêng nếu bạn dùng Echo.private('notifications.{userId}')
Broadcast::channel('notifications.{userId}', function ($user, $userId) {
    return $user->id === (int) $userId;
});

// Channel mặc định Laravel dùng cho Notification::send()
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return $user->id === (int) $id;
});
