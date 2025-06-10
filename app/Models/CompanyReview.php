<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CompanyReview extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'user_id',
        'rating',
        'title',
        'content',
        'pros',
        'cons',
        'position',
        'employment_type',
        'worked_year',
        'is_anonymous',
        'is_approved',
    ];

    protected $casts = [
        'is_anonymous' => 'boolean',
        'is_approved' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
