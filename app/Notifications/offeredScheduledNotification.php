<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\SystemNotificationMail;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

class offeredScheduledNotification extends Notification implements ShouldQueue
{
    use Queueable;

    protected $job;
    protected $offerDetails;

    public function __construct($job, $offerDetails = null)
    {
        $this->job = $job;
        $this->offerDetails = $offerDetails;
    }

    public function via($notifiable)
    {
        return ['mail']; // gửi qua email
    }

    public function toMail($notifiable)
    {
        $content = "Chúc mừng bạn! Bạn đã được chọn cho vị trí {$this->job->title}.";

        if ($this->offerDetails) {
            $content .= "\nThông tin offer: {$this->offerDetails}";
        }

        $mail = new SystemNotificationMail($content);
        $mail->to($notifiable->email);

        return $mail;    
    }

}
