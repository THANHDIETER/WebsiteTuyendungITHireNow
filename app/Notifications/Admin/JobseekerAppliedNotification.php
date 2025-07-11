<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Job;
use App\Models\User;

class JobseekerAppliedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public function __construct(public Job $job, public User $jobseeker) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "Ứng viên {$this->jobseeker->name} đã ứng tuyển vào vị trí {$this->job->title}.",
            'link_url' => route('admin.notifications.index', ['job_id' => $this->job->id]),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
