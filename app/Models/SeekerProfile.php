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
    ];

    protected $casts = [
        'is_visible' => 'boolean',
        'salary_expectation' => 'integer',
        'years_of_experience' => 'integer',
    ];

    /**
     * Mối quan hệ: Hồ sơ này thuộc về người dùng nào.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
