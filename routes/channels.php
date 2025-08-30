<?php

use Illuminate\Support\Facades\Broadcast;
use Illuminate\Support\Facades\Cache;
use App\Models\Conversation;

Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    $convIds = Cache::remember("user_conversations_{$user->id}", 600, function () use ($user) {
        return Conversation::where('user_one', $user->id)
            ->orWhere('user_two', $user->id)
            ->pluck('id')
            ->toArray();
    });
    $user->update(['last_login_at' => now()]);

    return in_array((int) $conversationId, $convIds, true);
});

Broadcast::channel('App.Models.User.{id}', fn($user, $id) => (int) $user->id === (int) $id);
