<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable, HasRoles, HasFactory;


    protected $fillable = [
        'email',
        'password',
        'role',
    ];

    public $timestamps = true;

    protected $hidden = [
        'password',
        'remember_token',
    ];

    public function getAuthPassword()
    {
        return $this->password;
    }


    /**
     * Quan hệ: người dùng có nhiều hồ sơ.
     */
    public function resumes()
    {
        return $this->hasMany(Resume::class);
    }
}
