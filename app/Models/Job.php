<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'title',
        'description',
        'requirements',
        'thumbnail',
        'benefits',
        'salary_min',
        'salary_max',
        'salary_negotiable',
        'salary_display',
        'address',
        'experience_id',
        'meta_title',
        'meta_description',
        'keyword',
        'search_index',
        'currency',
        'remote_policy_id',
        'language_id',
        'deadline',
        'company_id',
        'slug',
        'status',
        'is_approved',
        'views',
        'is_featured',
        'salary_display',
        'is_paid',
        'level_id',
        'job_type_id',
        'location_id',
        ''
    ];


    protected $casts = [
        'salary_negotiable' => 'boolean',
        'benefits' => 'array',
        'is_featured' => 'boolean',
        'is_paid' => 'boolean',
        'search_index' => 'boolean',
        'deadline' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    // 🔗 Relations
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'job_category', 'job_id', 'category_id');
    }
    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill')
            ->withPivot('priority_level', 'required')
            ->withTimestamps();
    }
    public function jobType()
    {
        return $this->belongsTo(JobType::class, 'job_type_id');
    }


    // 🔘 Accessors
    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'draft' => '<span class="badge bg-secondary">Bản nháp</span>',
            'published' => '<span class="badge bg-success">Đã đăng</span>',
            'closed' => '<span class="badge bg-dark">Đã đóng</span>',
            'rejected' => '<span class="badge bg-danger">Từ chối</span>',
            'pending' => '<span class="badge bg-warning text-dark">Chờ duyệt</span>',
            default => '<span class="text-muted">Không xác định</span>',
        };
    }

    public function getJobTypeLabelAttribute()
    {
        return match ($this->job_type) {
            'full-time' => 'Toàn thời gian',
            'part-time' => 'Bán thời gian',
            'internship' => 'Thực tập sinh',
            'remote' => 'Làm việc từ xa',
            'freelance' => 'Freelance',
            default => ucfirst($this->job_type)
        };
    }

    public function getFeaturedBadgeAttribute()
    {
        return $this->is_featured
            ? '<span class="badge bg-warning text-dark">Nổi bật</span>'
            : '<span class="text-muted">-</span>';
    }

    public function getSalaryRangeAttribute()
    {
        if ($this->salary_min && $this->salary_max) {
            return number_format($this->salary_min) . ' - ' . number_format($this->salary_max) . ' ' . strtoupper($this->currency);
        }

        return 'Thương lượng';
    }
    public function level()
    {
        return $this->belongsTo(Level::class);
    }

    public function experience()
    {
        return $this->belongsTo(JobExperience::class);
    }
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function language()
    {
        return $this->belongsTo(JobLanguage::class);
    }

    public function remotePolicy()
    {
        return $this->belongsTo(RemotePolicy::class);
    }
    // locations
    public function location()
    {
        return $this->belongsTo(Location::class);
    }
    public function recruiter()
{
    return $this->belongsTo(User::class, 'user_id');
}

    public function interviews()
    {
        return $this->hasMany(Interview::class);
    }

    public function employer()
    {
        return $this->belongsTo(\App\Models\Employer::class);
    }
}
