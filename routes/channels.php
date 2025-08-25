<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;
use App\Models\Conversation;

/**
 * Channel chat.{conversationId}
 * -> kiểm tra user có trong cuộc trò chuyện không
 * -> cache 10 phút
 */
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return Cache::remember("chat_access_{$user->id}_{$conversationId}", 600, function () use ($user, $conversationId) {
        return Conversation::where('id', $conversationId)
            ->where(function ($q) use ($user) {
                $q->where('user_one', $user->id)
                  ->orWhere('user_two', $user->id);
            })
            ->exists();
    });
});

/**
 * Channel user.{id}
 * -> cho phép user chỉ join channel của chính họ
 * -> cache 10 phút
 */
Broadcast::channel('user.{id}', function ($user, $id) {
    return Cache::remember("broadcast_user_channel1_{$user->id}_{$id}", 600, function () use ($user, $id) {
        return (int) $user->id === (int) $id;
    });
});

/**
 * Channel App.Models.User.{id}
 * -> Laravel mặc định dùng cho notifications
 * -> cache 10 phút
 */
Broadcast::channel('App.Models.User.{id}', function ($user, $id) {
    return Cache::remember("broadcast_user_channel2_{$user->id}_{$id}", 600, function () use ($user, $id) {
        return (int) $user->id === (int) $id;
    });
});
