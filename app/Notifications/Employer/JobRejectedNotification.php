<?php

namespace App\Notifications\Employer;

use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class JobRejectedNotification extends Notification implements ShouldBroadcastNow
{
    public function __construct(public $job, public $reason = null) {}

    public function via($notifiable) { return ['database', 'broadcast']; }

    public function toArray($notifiable)
    {
        return [
            'message' => "Tin tuyển dụng '{$this->job->title}' đã bị từ chối.",
            'link_url' => route('notifications.index'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
