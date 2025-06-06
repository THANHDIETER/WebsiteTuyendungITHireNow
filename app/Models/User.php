<?php

namespace App\Models;

use App\Http\Middleware\AdminMiddleware;
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
        'password',
        'name',
        'phone_number',
        'role',
        'status',
        'email_verified_at',
        'last_login_at'
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public $timestamps = true;



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
    public function company()
    {
        return $this->hasOne(Company::class);
    }


}
