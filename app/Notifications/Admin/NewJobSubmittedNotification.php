<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Job;

class NewJobSubmittedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public Job $job;

    public function __construct(Job $job)
    {
        $this->job = $job;
    }

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "Nhà tuyển dụng <strong>{$this->job->company->name}</strong> vừa đăng tin mới: <strong>{$this->job->title}</strong>.",
            'link_url' => route('admin.jobs.show', $this->job->id),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
