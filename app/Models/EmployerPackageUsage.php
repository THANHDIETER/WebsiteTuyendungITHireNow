<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPackageUsage extends Model
{
    protected $fillable = [
        'company_id', 'employer_package_id', 'post_limit', 'posts_used', 
        'start_date', 'end_date', 'is_active', 'price'
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function employerPackage()
    {
        return $this->belongsTo(EmployerPackage::class);
    }
}