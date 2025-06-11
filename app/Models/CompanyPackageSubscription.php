<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class CompanyPackageSubscription extends Model
{
    use HasFactory;

    protected $fillable = [
        'company_id',
        'employer_package_id',
        'start_date',
        'end_date',
        'post_limit',
        'remaining_posts',
        'highlight_days',
        'cv_view_limit',
        'support_level',
        'price',
        'payment_status',
        'is_active',
        'purchased_by_user_id',
    ];

    protected $dates = ['start_date', 'end_date'];

    // Relationships
    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function package()
    {
        return $this->belongsTo(EmployerPackage::class, 'employer_package_id');
    }

    public function purchaser()
    {
        return $this->belongsTo(User::class, 'purchased_by_user_id');
    }

    // Helpers
    public function isExpired(): bool
    {
        return now()->greaterThan($this->end_date);
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->where('end_date', '>=', now());
    }
}
