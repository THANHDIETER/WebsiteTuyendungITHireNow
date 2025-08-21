<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\SystemNotificationMail;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue; // 👈 thêm

class InterviewRejectedNotification extends Notification implements ShouldQueue // 👈 implements ShouldQueue
{
    use Queueable;

    protected $job;
    protected $rejectionReason;

    public function __construct($job, $rejectionReason = null)
    {
        $this->job = $job;
        $this->rejectionReason = $rejectionReason;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        $messageText = 'Chúng tôi rất tiếc thông báo rằng bạn đã không được chọn cho vị trí "' . $this->job->title . '".';

        if ($this->rejectionReason) {
            $messageText .= "\nLý do: " . $this->rejectionReason;
        }

        $messageText .= "\nCảm ơn bạn đã quan tâm và dành thời gian tham gia phỏng vấn.";

        return new SystemNotificationMail($messageText);
    }

}
