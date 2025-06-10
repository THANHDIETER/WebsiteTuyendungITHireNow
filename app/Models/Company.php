<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo_url',
        'cover_image_url',
        'website',
        'email',
        'phone',
        'address',
        'city',
        'company_size',
        'founded_year',
        'industry',
        'description',
        'benefits',
        'latitude',
        'longitude',
        'is_verified',
        'status',
        'meta_title',
        'meta_description',
        'search_index',
    ];

    protected $casts = [
        'benefits' => 'array',
        'is_verified' => 'boolean',
        'search_index' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    /**
     * Mối quan hệ với user (chủ sở hữu công ty)
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Mối quan hệ: công ty có nhiều job
     */
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }

    /**
     * Mối quan hệ: công ty có nhiều đánh giá
     */
    public function reviews()
    {
        return $this->hasMany(CompanyReview::class);
    }
}
