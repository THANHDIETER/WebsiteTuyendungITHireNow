<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployerPackageUsage extends Model
{
    use HasFactory;

    protected $table = 'employer_package_usages';

    protected $fillable = [
        'company_id',
        'employer_package_id',
        'post_limit',
        'posts_used',
        'start_date',
        'end_date',
        'is_active',
    ];

    protected $dates = ['start_date', 'end_date'];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }

    public function package()
    {
        return $this->belongsTo(EmployerPackage::class, 'employer_package_id');
    }
}
