<?php

namespace App\Events;

use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Broadcasting\{Channel, PrivateChannel};
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NotificationSent implements ShouldQueue
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


    public function broadcastWith(): array
    {
        return $this->notification;
    }

}
