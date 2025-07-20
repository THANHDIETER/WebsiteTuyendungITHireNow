<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Message extends Model
{
    use HasFactory;

    protected $fillable = ['conversation_id', 'sender_id', 'message'];

    // Cuộc trò chuyện mà tin nhắn này thuộc về
    public function conversation()
    {
        return $this->belongsTo(Conversation::class);
    }

    // Người gửi tin nhắn
    public function sender()
    {
        return $this->belongsTo(User::class, 'sender_id');
    }
}
