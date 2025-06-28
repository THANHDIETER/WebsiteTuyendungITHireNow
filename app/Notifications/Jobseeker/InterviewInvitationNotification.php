<?php

namespace App\Notifications\Jobseeker;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class InterviewInvitationNotification extends Notification implements ShouldBroadcast
{
    public function __construct(public $job, public $interviewDateTime) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Bạn được mời phỏng vấn vị trí '{$this->job->title}' lúc {$this->formatTime($this->interviewDateTime)}.",
            'link_url' => route('job_seeker.notifications.index'),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }

    private function formatTime($datetime)
    {
        return \Carbon\Carbon::parse($datetime)->format('H:i d/m/Y');
    }
}
