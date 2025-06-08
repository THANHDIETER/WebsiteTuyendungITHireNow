<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SystemNotificationMail extends Mailable
{
    use Queueable, SerializesModels;

    public $messageText;
    public $link;

    public function __construct($messageText, $link = null)
    {
        $this->messageText = $messageText;
        $this->link = $link;
    }

    public function build()
    {
        return $this->subject('Thông báo hệ thống')
                    ->view('emails.system_notification');
    }
}
