<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\EmployerServicePackage;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable, HasRoles, HasFactory;

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
        return $this->password;
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
        return $this->hasOne(Company::class, 'user_id', 'id');
    }

    public function currentPackage()
    {
        return $this->hasOne(Payment::class)
            ->where('status', 'paid')
            ->latestOfMany(); // lấy đơn thanh toán hợp lệ gần nhất
    }
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }




}
