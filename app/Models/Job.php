<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Job extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'company_id',
        'title',
        'slug',
        'description',
        'requirements',         // ⬅️ mô tả ngắn gọn
        'benefits',
        'job_type',
        'salary_min',
        'salary_max',
        'currency',
        'location',
        'address',
        'level',
        'experience',
        'category_id',
        'deadline',
        'status',
        'views',
        'is_featured',
        'is_paid',
        'apply_url',
        'remote_policy',
        'language',
        'meta_title',
        'meta_description',
        'search_index',
        'keyword',
        'thumbnail'            // ⬅️ ảnh đại diện
    ];

    protected $casts = [
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

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function skills()
    {
        return $this->belongsToMany(Skill::class, 'job_skill')->withPivot('priority_level', 'required');
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
}
