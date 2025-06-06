<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;
use Laravel\Sanctum\PersonalAccessToken;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable, HasRoles;
    /**
     * Các trường có thể được gán giá trị (Mass Assignment).
     */
    protected $fillable = [
        'email',
        'password',
        'name',
        'phone_number',
        'role',
        'status',
        'email_verified_at',
        'last_login_at',
    ];

    /**
     * Các trường ẩn khi trả về dữ liệu (Hidden Attributes).
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Các kiểu dữ liệu cần được chuyển đổi (Type Casting).
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    /**
     * Thiết lập sử dụng timestamp (created_at, updated_at).
     */
    public $timestamps = true;

    /**
     * Định nghĩa phương thức để trả về mật khẩu.
     */
    public function getAuthPassword()
    {
        return $this->password;
    }

    /**
     * Quan hệ: người dùng có nhiều hồ sơ (Resume).
     */
    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }

    /**
     * Quan hệ: người dùng có nhiều token (Sanctum).
     */
    public function tokens()
    {
        return $this->hasMany(PersonalAccessToken::class);
    }

    /**
     * Quan hệ khác (nếu cần).
     */
    // Ví dụ: Quan hệ với bảng Jobs nếu có
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    
}
