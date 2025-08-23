<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use App\Mail\SystemNotificationMail;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Contracts\Queue\ShouldQueue; // 👈 thêm dòng này

class InterviewScheduledNotification extends Notification implements ShouldQueue // 👈 implements ShouldQueue
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
        $message = "Bạn đã được mời phỏng vấn cho vị trí \"{$this->job->title}\".\n"
             . "⏰ Thời gian phỏng vấn: " . $this->interviewDate->format('d/m/Y H:i') . "\n"
             . "Vui lòng chuẩn bị kỹ và tham gia đúng giờ.\n"
             . "Cảm ơn bạn đã quan tâm đến vị trí này!";
    
        $mail = new SystemNotificationMail($message);
        $mail->to($notifiable->email);

        return $mail;   
    }
}   
