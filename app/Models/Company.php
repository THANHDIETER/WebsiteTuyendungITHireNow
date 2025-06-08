<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Company extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'name', 'slug', 'logo_url', 'cover_image_url', 'website',
        'email', 'phone', 'address', 'city', 'company_size', 'founded_year',
        'industry', 'description', 'benefits', 'is_verified', 'status'
    ];

    protected $casts = [
        'benefits' => 'array',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
}