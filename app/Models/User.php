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
        return $this->hasOne(Company::class);
    }

    public function getRoleLabelAttribute(): string
    {
        return match($this->role) {
            'job_seeker' => 'Người tìm việc',
            'employer'   => 'Nhà tuyển dụng',
            'admin'      => 'Quản trị viên',
            default      => 'Không xác định',
        };
    }
    public function getRoleBadgeClassAttribute(): string
    {
        return match($this->role) {
            'job_seeker' => 'badge bg-secondary',
            'employer'   => 'badge bg-info text-dark',
            'admin'      => 'badge bg-warning text-dark',
            default      => 'badge bg-light text-muted',
        };
    }

     public function getStatusLabelAttribute(): string
    {
        return match($this->status) {
            'active'   => 'Đang hoạt động',
            'inactive' => 'Chưa kích hoạt',
            'banned'   => 'Bị chặn',
            default    => 'Không xác định',
        };
    }
      public function getStatusBadgeClassAttribute(): string
    {
        return match($this->status) {
            'active'   => 'badge bg-success',
            'inactive' => 'badge bg-secondary',
            'banned'   => 'badge bg-danger',
            default    => 'badge bg-light text-muted',
        };
    }

}
