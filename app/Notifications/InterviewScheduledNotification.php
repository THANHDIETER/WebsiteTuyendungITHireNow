<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class InterviewScheduledNotification extends Notification
{
    use Queueable;

    protected $job;
    protected $interviewDate;

    public function __construct($job, $interviewDate)
    {
        $this->job = $job;
        $this->interviewDate = $interviewDate;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
            ->subject('Thư mời phỏng vấn cho vị trí ' . $this->job->title)
            ->greeting('Xin chào ' . $notifiable->name . ',')
            ->line('Bạn đã được mời phỏng vấn cho vị trí "' . $this->job->title . '".')
            ->line('Thời gian phỏng vấn: ' . $this->interviewDate->format('d/m/Y H:i'))
            ->line('Vui lòng chuẩn bị kỹ và tham gia đúng giờ.')
            ->line('Cảm ơn bạn đã quan tâm đến vị trí này!');
    }
}
