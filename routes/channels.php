<?php
use Illuminate\Support\Facades\Broadcast;
Broadcast::channel('chat.{conversationId}', function ($user, $conversationId) {
    return true; 
});

Broadcast::channel('user.{id}', function ($user, $id) {
    return (int) $user->id === (int) $id;
});

