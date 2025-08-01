<?php

namespace App\Models;

use Laravel\Sanctum\HasApiTokens;
use App\Models\EmployerServicePackage;
use Spatie\Permission\Traits\HasRoles;
use App\Http\Middleware\AdminMiddleware;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class User extends Authenticatable
{

    use HasApiTokens, Notifiable, HasRoles, HasFactory,SoftDeletes;
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

    public function favoriteJobs()
{
    return $this->belongsToMany(\App\Models\Job::class, 'favorites', 'user_id', 'job_id')
        ->withPivot('note')
        ->withTimestamps();
}


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
    public function messages()
    {
        return $this->hasMany(Message::class, 'sender_id');
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

    public function profile()
    {
        return $this->hasOne(SeekerProfile::class, 'user_id', 'id');
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }


    public function appliedJobs()
    {
        return $this->belongsToMany(Job::class, 'job_applications', 'user_id', 'job_id')
            ->withTimestamps(); // nếu bạn dùng created_at, updated_at
    }
    public static function roleOptions(): array
    {
        return [
            'job_seeker' => ['label' => 'Ứng viên', 'color' => 'primary'],     // màu xanh
            'employer' => ['label' => 'Nhà tuyển dụng', 'color' => 'success'], // màu xanh lá
            'admin' => ['label' => 'Quản trị viên', 'color' => 'danger'],   // màu đỏ
        ];
    }


    public function getRoleBadgeAttribute(): string
    {
        $options = self::roleOptions();
        $role = $this->role;

        if (!isset($options[$role])) {
            return '<span class="badge bg-secondary">Không xác định</span>';
        }

        $label = $options[$role]['label'];
        $color = $options[$role]['color'];

        return "<span class=\"badge bg-{$color}\">{$label}</span>";
    }

    public static function statusOptions(): array
    {
        return [
            'active' => ['label' => 'Hoạt động', 'color' => 'success'],  // Xanh lá
            'inactive' => ['label' => 'Không hoạt động', 'color' => 'secondary'], // Xám
            'banned' => ['label' => 'Đã bị cấm', 'color' => 'danger'],   // Đỏ
        ];
    }
    public function getStatusBadgeAttribute(): string
    {
        $options = self::statusOptions();
        $status = $this->status;

        if (!isset($options[$status])) {
            return '<span class="badge bg-secondary">Không xác định</span>';
        }

        $label = $options[$status]['label'];
        $color = $options[$status]['color'];

        return "<span class=\"badge bg-{$color}\">{$label}</span>";
    }
    public function unreadMessagesCount()
{
    return \App\Models\Conversation::where(function ($q) {
        $q->where('user_one', $this->id)->orWhere('user_two', $this->id);
    })->get()->sum(function ($conv) {
        return $conv->messages()
            ->where('sender_id', '!=', $this->id)
            ->whereNull('read_at')
            ->count();
    });
}

}