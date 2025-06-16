<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [ 'company_id', 'title', 'slug', 'description', 'requirements', 'benefits',
        'job_type', 'salary_min', 'salary_max', 'currency', 'location', 'address',
        'level', 'experience', 'category_id', 'deadline', 'status', 'views', 'is_featured',
        'apply_url', 'remote_policy', 'language', 'meta_title', 'meta_description', 'search_index', 'is_paid'
];

    protected $casts = [
        'benefits' => 'array',
        'is_featured' => 'boolean',
        'search_index' => 'boolean',
        'is_paid' => 'boolean',
        'deadline' => 'datetime',
        'deleted_at' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill')->withPivot('priority_level', 'required');
    }
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

        return '-';
    }

}

