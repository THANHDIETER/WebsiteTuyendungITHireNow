<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChatLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'session_id', 
        'message',
        'reply',
        'intent',
        'role' 
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
