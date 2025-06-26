<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;

class JobEditedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $job;

    public function __construct($job)
    {
        $this->job = $job;
    }

    /**
     * Determine delivery channels.
     */
    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    /**
     * Store notification in the database.
     */
    public function toArray($notifiable)
    {
        return [
            'message' => "Tin tuyển dụng '{$this->job->title}' đã được nhà tuyển dụng chỉnh sửa.",
            'link_url' => route('admin.jobs.show', $this->job->id), // tuỳ chỉnh route admin
        ];
    }

    /**
     * Broadcast notification for realtime.
     */
    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
