<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SeekerProfile extends Model
{
    use HasFactory;

    protected $table = 'seeker_profiles';

    protected $fillable = [
        'user_id',
        'full_name',
        'email',
        'phone',
        'date_of_birth',
        'gender',
        'city',
        'address',
        'about_me',
        'avatar',
        'headline',
        'summary',
        'cv_url',
        'linkedin_url',
        'github_url',
        'portfolio_url',
        'location',
        'salary_expectation',
        'years_of_experience',
        'job_types',
        'education',
        'work_experience',
        'language_skills',
        'is_visible',
        'created_at',
        'updated_at',
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'salary_expectation' => 'integer',
        'years_of_experience' => 'integer',
    ];

    /**
     * Mối quan hệ: Hồ sơ này thuộc về người dùng.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Định nghĩa các job types dạng array khi lưu và đọc (ví dụ: ["full-time", "remote"])
     */
    public function getJobTypesAttribute($value)
    {
        return explode(',', $value);
    }

    public function setJobTypesAttribute($value)
    {
        $this->attributes['job_types'] = is_array($value) ? implode(',', $value) : $value;
    }
}
