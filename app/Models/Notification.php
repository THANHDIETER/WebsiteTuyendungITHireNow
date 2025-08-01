<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    protected $table = 'notifications';
    protected $keyType = 'string';
    public $incrementing = false;

    protected $casts = [
        'data' => 'array',
        'read_at' => 'datetime',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $fillable = [
        'id', 'type', 'notifiable_type', 'notifiable_id', 'data', 'read_at'
    ];

     public function user()
    {
        return $this->belongsTo(User::class);
    }
}
