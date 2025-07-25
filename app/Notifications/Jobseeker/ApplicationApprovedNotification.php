<?php

namespace App\Notifications\Jobseeker;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ApplicationApprovedNotification extends Notification implements ShouldBroadcast
{
    public function __construct(public $job) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Đơn ứng tuyển của bạn vào vị trí '{$this->job->title}' đã được duyệt.",
            'link_url' => route('job_seeker.notifications.index'), // hoặc link tới job cụ thể
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
