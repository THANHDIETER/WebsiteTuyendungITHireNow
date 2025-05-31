<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;

    /**
     * Các trường có thể gán hàng loạt.
     */
    protected $fillable = [
        'email',
        'password', // Đã đổi từ password_hash sang password để Laravel/Sanctum hoạt động chuẩn
        'role',
    ];

    /**
     * Các trường ẩn khi trả về JSON.
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Kiểu dữ liệu tự động ép kiểu.
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Quan hệ: người dùng có nhiều hồ sơ.
     */
    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }
}
