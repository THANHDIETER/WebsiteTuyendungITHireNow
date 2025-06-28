<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobType extends Model
{
    use HasFactory;

    protected $table = 'job_types'; // rõ ràng nếu không tuân theo chuẩn Laravel

    protected $fillable = [
        'name', 'slug', 'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public function jobs()
    {
        return $this->hasMany(Job::class, 'job_type_id');
    }
}
