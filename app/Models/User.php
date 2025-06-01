<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable, HasRoles;


    protected $fillable = [
        'email',
        'password', // Đã đổi từ password_hash sang password để Laravel/Sanctum hoạt động chuẩn
        'role',
    ];


    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password_hash;
    }


    /**
     * Quan hệ: người dùng có nhiều hồ sơ.
     */
    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }
}
