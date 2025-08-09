<?php

namespace App\Notifications\Admin;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;
use App\Models\Job;


class JobEditedNotification extends Notification implements ShouldBroadcastNow
{
    use Queueable;


    public $job;

    public function __construct($job)

    {
        $this->job = $job;
    }

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
            'message' => "Tin tuyển dụng {$this->job->title} vừa được nhà tuyển dụng cập nhật lại thông tin. Vui lòng kiểm tra để đảm bảo các thay đổi phù hợp với tiêu chuẩn của hệ thống.",
            'link_url' => route('notifications.index'),
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