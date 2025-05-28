<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_url',
        'is_approved',
    ];

    // Quan hệ: mỗi resume thuộc về một user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}