<?php
namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class TypingEvent implements ShouldQueue
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public $conversationId, $userId, $userName, $userAvatar;

    public function __construct($conversationId, $userId, $userName, $userAvatar = null)
    {
        $this->conversationId = $conversationId;
        $this->userId = $userId;
        $this->userName = $userName;
        $this->userAvatar = $userAvatar;
    }

    public function broadcastOn()
    {
        return new PrivateChannel('chat.' . $this->conversationId);
    }
}
