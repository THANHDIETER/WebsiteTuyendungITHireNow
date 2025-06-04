<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
<<<<<<< HEAD
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
=======

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;
>>>>>>> b491f5cec2dc42594dcf88613234fcce7cc69751

    use HasApiTokens, Notifiable, HasRoles;


    protected $fillable = [
        'name',
        'email',
<<<<<<< HEAD
        'password_hash', // Đã đổi từ password_hash sang password để Laravel/Sanctum hoạt động chuẩn
        'role',
=======
        'password',
>>>>>>> b491f5cec2dc42594dcf88613234fcce7cc69751
    ];

    public $timestamps = true;

    protected $hidden = [
        'password',
        'remember_token',
    ];

<<<<<<< HEAD
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
=======
    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
>>>>>>> b491f5cec2dc42594dcf88613234fcce7cc69751
    }
}
