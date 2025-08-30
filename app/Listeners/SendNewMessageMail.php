<?php

namespace App\Listeners;

use App\Events\MessageSent;
use App\Mail\SystemNotificationMail;
use App\Models\User;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Mail;

class SendNewMessageMail
{
    /**
     * Handle the event.
     */
    public function handle(MessageSent $event): void
    {
        $message = $event->message;
        $conversation = $message->conversation;

        // Xác định người nhận (ngược lại với sender)
        $recipientId = $conversation->user_one == $message->sender_id
            ? $conversation->user_two
            : $conversation->user_one;

        $recipient = User::find($recipientId);

        if (!$recipient) return;

        // Check offline > 5 phút
        $offlineThreshold = Carbon::now()->subMinutes(5);

        if (is_null($recipient->last_login_at) || $recipient->last_login_at < $offlineThreshold) {
            // Soạn nội dung mail
            $text = "Bạn vừa nhận được tin nhắn từ {$message->sender->name}: \"{$message->message}\"";
            $link = route('chat.index');

            // Gửi mail qua Mailable
            Mail::to($recipient->email)->queue(new SystemNotificationMail($text, $link));
        }
    }
}
