<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{

    use HasFactory;

    protected $fillable = [
        'user_id', 'type', 'message', 'link_url', 'is_read', 'read_at', 'is_sent'

    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}

