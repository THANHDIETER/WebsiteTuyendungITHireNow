<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'description',
        'icon_url',
        'is_active',
        'sort_order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jobs()
    {
        return $this->belongsToMany(Job::class, 'job_category', 'category_id', 'job_id')
            ->withTimestamps()
            ->withTrashed(); // nếu có dùng softDeletes
    }


    public function skills()
    {
        return $this->hasMany(Skill::class);
    }
}