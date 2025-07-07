<?php

namespace App\Models;

use Illuminate\Notifications\DatabaseNotification;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;

class Notification extends DatabaseNotification
{
    use HasFactory;

    protected $table = 'notifications';

    // Nếu bạn không dùng cột `data` mặc định, bạn có thể thêm các trường custom ở đây
    protected $fillable = [
        'type',
        'notifiable_type',
        'notifiable_id',
        'message',
        'link_url',
        'is_read',
        'read_at',
        'is_sent',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_read' => 'boolean',
        'is_sent' => 'boolean',
        'read_at' => 'datetime',
    ];

    /**
     * Quan hệ morphTo đến bất kỳ model nào (User, Admin, ...)
     * Laravel mặc định dùng: notifiable_type + notifiable_id
     */
    public function notifiable()
    {
        return $this->morphTo();
    }

    /**
     * Shortcut alias nếu bạn chỉ gửi noti cho User
     * Giúp gọi $notification->user thay vì $notification->notifiable
     */
    public function user()
    {
        return $this->morphTo(__FUNCTION__, 'notifiable_type', 'notifiable_id');
    }

    /**
     * Truy cập nội dung chính từ data (nếu dùng)
     */
    protected function message(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => $value ?? ($attributes['data'] ? json_decode($attributes['data'], true)['message'] ?? null : null),
        );
    }

    /**
     * Shortcut để biết đã đọc hay chưa
     */
    public function getIsReadAttribute($value)
    {
        return $value ?? !is_null($this->read_at);
    }
}
