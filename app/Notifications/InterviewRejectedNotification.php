<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InterviewRejectedNotification extends Notification
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
        $mail = (new MailMessage)
            ->subject('Thông báo từ chối phỏng vấn vị trí ' . $this->job->title)
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Chúng tôi rất tiếc thông báo rằng bạn đã không được chọn cho vị trí "' . $this->job->title . '".');

        if ($this->rejectionReason) {
            $mail->line('Lý do: ' . $this->rejectionReason ?? 'Không có lý do cụ thể được cung cấp.');
        }

        $mail->line('Cảm ơn bạn đã quan tâm và dành thời gian tham gia phỏng vấn.');

        return $mail;
    }
}
