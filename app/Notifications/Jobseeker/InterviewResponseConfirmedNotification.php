<?php

namespace App\Notifications\Jobseeker;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Messages\BroadcastMessage;

class InterviewResponseConfirmedNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;

    protected $interview;

    public function __construct($interview)
    {
        $this->interview = $interview;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Phản hồi của bạn về cuộc phỏng vấn vị trí '{$this->interview->job->title}' đã được ghi nhận.",
            'link_url' => route('notifications.index'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
