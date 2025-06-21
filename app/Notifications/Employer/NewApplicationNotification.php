<?php
namespace App\Notifications\Employer;

use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class NewApplicationNotification extends Notification implements ShouldBroadcast
{
    public function __construct(public $job, public $jobseeker) {
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Ứng viên {$this->jobseeker->name} đã ứng tuyển vào vị trí '{$this->job->title}'.",
            'link_url' => route('employer.jobs.applications', $this->job->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
