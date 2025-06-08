<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AdminLog extends Model
{
    use HasFactory;

    protected $fillable = [
        'admin_id', 'action', 'target_type', 'target_id', 'description',
        'ip_address', 'browser_info', 'user_before', 'user_after', 'entity_changes', 'log_level'
    ];

    protected $casts = [
        'user_before' => 'array',
        'user_after' => 'array',
        'entity_changes' => 'array',
    ];

    public function admin()
    {
        return $this->belongsTo(User::class, 'admin_id');
    }
}