<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewJobSubmittedNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    public function __construct(public $job) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Nhà tuyển dụng '{$this->job->company->name}' đã gửi tin tuyển dụng: '{$this->job->title}'.",
            'link_url' => route('notifications.index'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
