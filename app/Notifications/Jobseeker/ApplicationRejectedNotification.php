<?php

namespace App\Notifications\Jobseeker;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ApplicationRejectedNotification extends Notification implements ShouldBroadcast
{
    public function __construct(public $job) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Đơn ứng tuyển của bạn vào vị trí '{$this->job->title}' đã bị từ chối.",
            'link_url' => url('/job-seeker/notifications'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
