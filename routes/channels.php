<?php
use Illuminate\Support\Facades\Broadcast;
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return true; // hoặc kiểm tra quyền nếu cần
});

