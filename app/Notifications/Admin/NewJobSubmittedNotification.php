<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class NewJobSubmittedNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public $job) {}

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        $company = $this->job->company->name ?? 'Nhà tuyển dụng';
        $title   = $this->job->title ?? 'Tin tuyển dụng';

        return [
            'type'     => 'admin.new_job_submitted',
            'title'    => 'Tin tuyển dụng mới',
            'icon'     => 'bi-briefcase-fill',
            'message'  => "Nhà tuyển dụng '{$company}' đã gửi tin tuyển dụng: '{$title}'.",
            'link_url' => route('admin.jobs.show', $this->job->id),
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
