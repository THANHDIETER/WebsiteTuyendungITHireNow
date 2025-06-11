<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPackageUsage extends Model
{
    protected $fillable = [
        'company_id',
        'employer_package_id',
        'post_limit',
        'used_posts',
        'start_date',
        'end_date',
        'is_active',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class, 'company_id');
    }

    public function employerPackage()
    {
        return $this->belongsTo(EmployerPackage::class, 'employer_package_id');
    }
}

