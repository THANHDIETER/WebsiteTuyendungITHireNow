<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Report extends Model
{
    use HasFactory;

    protected $fillable = [
        'target_type',
        'target_id',
        'reporter_id',
        'reason_code',
        'message',
        'status',
        'resolved_by',
        'admin_note',
        'seen_at',
        'ip_address',
        'user_agent',
    ];

    /**
     * Đối tượng bị báo cáo (đa hình: job, user, company, ...)
     */
    public function target()
    {
        return $this->morphTo();
    }

    /**
     * Người gửi báo cáo
     */
    public function reporter()
    {
        return $this->belongsTo(User::class, 'reporter_id');
    }

    /**
     * Admin xử lý báo cáo
     */
    public function resolver()
    {
        return $this->belongsTo(User::class, 'resolved_by');
    }
}
