<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPackage extends Model
{
    protected $fillable = [
        'name',
        'description',
        'price',
        'duration_days',
        'post_limit',
        'highlight_days',
        'cv_view_limit',
        'support_level',
        'sort_order',
        'is_active',
    ];

    // Optional: Gói có nhiều giao dịch (payments)
    public function payments()
    {
        return $this->hasMany(Payment::class, 'package_id');
    }
        public function subscriptions()
    {
        return $this->hasMany(CompanyPackageSubscription::class);
    }

}
