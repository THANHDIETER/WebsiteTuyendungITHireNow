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
        'date_of_birth' => 'date',
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
        return $this->hasOne(Company::class);
    }

    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function appliedJobs()
    {
        return $this->belongsToMany(Job::class, 'job_applications', 'user_id', 'job_id')
            ->withTimestamps(); // nếu bạn dùng created_at, updated_at
    }
}
