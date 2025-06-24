<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerPackage extends Model
{
    protected $table = 'employer_packages';
    public $timestamps = true;
    protected $dateFormat = 'Y-m-d H:i:s';
    
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
    
    public function payments()
    {
        return $this->hasMany(Payment::class, 'package_id');
    }

}
