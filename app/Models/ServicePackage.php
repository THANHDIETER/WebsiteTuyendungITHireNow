<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    protected $table = 'service_packages';

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
        'created_at',
        'updated_at'
    ];

    public function package()
    {
        return $this->belongsTo(ServicePackage::class, 'package_id');
    }
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
   
    public function companySubscriptions()
    {
        return $this->hasMany(CompanyPackageSubscription::class, 'package_id');
    }
    public function payments()
    {
        return $this->hasMany(Payment::class, 'package_id');
    }
}
