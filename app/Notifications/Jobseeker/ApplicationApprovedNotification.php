<?php

namespace App\Notifications\Jobseeker;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;

class ApplicationApprovedNotification extends Notification implements ShouldBroadcastNow
{
    public function __construct(public $job) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Chúc mừng! Bạn đã trúng tuyển vào vị trí '{$this->job->title}'. Hãy kiểm tra email.",
            'link_url' => route('notifications.index'), // hoặc link cụ thể đến job
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
