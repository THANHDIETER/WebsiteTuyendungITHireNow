<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;
use App\Models\Conversation;

/**
 * Channel chat.{conversationId}
 * -> check user có trong conversation không
 * -> dùng cache để tránh query DB liên tục
 */
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    // Lấy danh sách conversationIds của user từ cache (10 phút)
    $convIds = Cache::remember("user_conversations_{$user->id}", 600, function () use ($user) {
        return Conversation::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)
            ->pluck('id')
            ->toArray();
    });

    return in_array((int) $conversationId, $convIds, true);
});

/**
 * Channel user.{id}
 * -> user chỉ join channel của chính họ
 */
Broadcast::channel('user.{id}', fn($user, $id) => (int) $user->id === (int) $id);

/**
 * Channel App.Models.User.{id}
 * -> Laravel Notifications mặc định
 */
Broadcast::channel('App.Models.User.{id}', fn($user, $id) => (int) $user->id === (int) $id);
