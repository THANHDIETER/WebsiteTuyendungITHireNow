<?php
namespace App\Notifications\Admin;

use App\Models\User;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\BroadcastMessage;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;

class NewJobseekerRegisteredNotification extends Notification implements ShouldBroadcast
{
    public function __construct(public User $jobseeker) {}

    public function via($notifiable): array
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable): array
    {
        return [
            'message' => "Ứng viên <strong>{$this->jobseeker->email}</strong> vừa đăng ký tài khoản.",
            'link_url' => route('admin.jobseekers.index'),
        ];
    }

    public function toBroadcast($notifiable): BroadcastMessage
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
