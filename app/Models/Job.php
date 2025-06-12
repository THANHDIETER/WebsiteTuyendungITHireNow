<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
<<<<<<< HEAD
        'company_id',
        'title',
        'slug',
        'description',
        'requirements',
        'benefits',
        'job_type_id',
        'salary_min',
        'salary_max',
        'currency',
        'location_id',
        'address',
        'level',
        'experience_id',
        'category_id',
        'deadline',
        'status',
        'views',
        'is_featured',
        'apply_url',
        'remote_policy',
        'language',
        'meta_title',
        'meta_description',
        'search_index',
        'degree_id'
=======
        'company_id', 'title', 'slug', 'description', 'requirements', 'benefits',
        'job_type', 'salary_min', 'salary_max', 'currency', 'location', 'address',
        'level', 'experience', 'category_id', 'deadline', 'status', 'views', 'is_featured',
        'apply_url', 'remote_policy', 'language', 'meta_title', 'meta_description', 'search_index', 'is_paid'
>>>>>>> b112181 (luồng chính web)
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
}
