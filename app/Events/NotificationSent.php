<?php

namespace App\Events;

use Illuminate\Broadcasting\{Channel, PrivateChannel};
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Queue\SerializesModels;
use Illuminate\Foundation\Events\Dispatchable;

class NotificationSent implements ShouldBroadcast
{
    use Dispatchable, SerializesModels;

    public function __construct(
        public array $notification,
        public int $userId
    ) {}

    public function broadcastOn(): Channel
    {
        return new PrivateChannel("notifications.{$this->userId}");
    }

    public function broadcastAs(): string
    {
        return 'notification.sent';
    }
}
