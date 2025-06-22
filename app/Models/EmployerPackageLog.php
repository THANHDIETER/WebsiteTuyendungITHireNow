<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPackageLog extends Model
{
    protected $table = 'employer_package_logs'; 
    protected $fillable = [
        'order_id',
        'job_id',
        'used_at',
        'action',
    ];

    protected $casts = [
        'used_at' => 'datetime',
    ];

    public function order()
    {
        return $this->belongsTo(EmployerPackageOrder::class, 'order_id');
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}

