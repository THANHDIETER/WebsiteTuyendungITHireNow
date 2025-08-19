<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
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
        $mail = (new MailMessage)
            ->subject('Chúc mừng! Bạn đã trúng tuyển vị trí ' . $this->job->title)
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Chúc mừng bạn! Bạn đã được chọn cho vị trí "' . $this->job->title . '".');

        if ($this->offerDetails) {
            $mail->line('Thông tin offer: ' . $this->offerDetails);
        }

        $mail->line('Chúng tôi sẽ liên hệ để trao đổi thêm chi tiết.')
            ->line('Cảm ơn bạn đã quan tâm và ứng tuyển vào công ty chúng tôi.');

        return $mail;
    }
}
