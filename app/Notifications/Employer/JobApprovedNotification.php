<?php

namespace App\Notifications\Employer;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class JobApprovedNotification extends Notification implements ShouldBroadcast
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
            'message' => "Tin tuyển dụng '{$this->job->title}' đã được phê duyệt.",
            'link_url' => route('employer.jobs.show', $this->job->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
