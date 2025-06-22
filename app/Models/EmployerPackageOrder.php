<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPackageOrder extends Model
{
    protected $fillable = [
        'company_id',
        'employer_package_id',
        'post_limit',
        'post_used',
        'start_date',
        'end_date',
        'status',
    ];

    protected $casts = [
        'start_date' => 'datetime',
        'end_date' => 'datetime',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function package()
    {
        return $this->belongsTo(EmployerPackage::class, 'employer_package_id');
    }

    public function logs()
    {
        return $this->hasMany(EmployerPackageLog::class, 'order_id');
    }
}

