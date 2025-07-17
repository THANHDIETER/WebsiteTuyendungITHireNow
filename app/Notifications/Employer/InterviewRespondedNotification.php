<?php

namespace App\Notifications\Employer;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Notifications\Messages\BroadcastMessage;

class InterviewRespondedNotification extends Notification implements ShouldBroadcast
{
    use Queueable;

    public $interview;
    public $response;
    public $note;

    public function __construct($interview, $response, $note = null)
    {
        $this->interview = $interview;
        $this->response = $response;
        $this->note = $note;
    }

    public function via($notifiable)
    {
        return ['database', 'broadcast'];
    }

    public function toArray($notifiable)
    {
        return [
            'message' => "Ứng viên {$this->interview->jobseeker->name} đã " .
                ($this->response === 'accepted' ? 'chấp nhận' : 'từ chối') .
                " lời mời phỏng vấn vị trí '{$this->interview->job->title}'.",
            'note' => $this->note,
            'link_url' => url("/employer/interviews/{$this->interview->id}")
        ];
    }

    public function toBroadcast($notifiable)
    {
        return new BroadcastMessage($this->toArray($notifiable));
    }
}
