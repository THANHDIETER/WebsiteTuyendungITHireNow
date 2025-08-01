<?php

namespace App\Models;

use App\Models\JobApplication;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\User;

class Company extends Model
{
    use HasFactory;

    protected $table = 'companies';

    protected $fillable = [
        'user_id',
        'name',
        'slug',
        'logo_url',
        'cover_image_url',
        'website',
        'email',
        'phone',
        'address',
        'city',
        'company_size',
        'founded_year',
        'industry',
        'description',
        'benefits',
        'latitude',
        'longitude',
        'is_verified',
        'status',
        'meta_title',
        'meta_description',
        'search_index',
    ];

    protected $casts = [
        'benefits' => 'array',
        'is_verified' => 'boolean',
        'search_index' => 'boolean',
        'latitude' => 'float',
        'longitude' => 'float',
    ];

    // Chủ sở hữu công ty
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Danh sách việc làm của công ty
    public function jobs()
    {
        return $this->hasMany(Job::class);
    }
    public function jobApplications()
    {
        return $this->hasMany(JobApplication::class);
    }
    // Đánh giá công ty
    public function reviews()
    {
        return $this->hasMany(CompanyReview::class);
    }

    // Danh sách các lần mua package của công ty
    public function employerPackageUsages()
    {
        // Giả định bạn có model EmployerPackageUsage (liên kết với bảng employer_package_usages)
        return $this->hasMany(EmployerPackageUsage::class, 'company_id');
    }

    // Danh sách subscription package (nếu dùng bảng subscriptions riêng)
    public function packageSubscriptions()
    {
        return $this->hasMany(CompanyPackageSubscription::class, 'company_id');
    }

    // Lấy package subscription còn hiệu lực mới nhất
    public function activePackage()
    {
        return $this->hasOne(Payment::class, 'user_id', 'user_id')
            ->where('status', 'paid')
            ->whereNotNull('paid_at')
            ->latest('paid_at')
            ->first()?->package;
    }




    // Lấy package có lượt đăng còn lại (trả phí, còn hạn, còn quota)
    public function activeEmployerPackage()
    {
        return $this->employerPackageUsages()
            ->where('is_active', true)
            ->where('end_date', '>=', now())
            ->whereColumn('posts_used', '<', 'post_limit')
            ->orderBy('end_date')
            ->first();
    }

    // Tổng số lượt đăng còn lại (free + paid)
    public function getPostingQuota()
    {
        $free = $this->getFreeQuotaRemain();
        $pkg = $this->activeEmployerPackage();
        $paid = $pkg ? ($pkg->post_limit - $pkg->posts_used) : 0;
        return $free + $paid;
    }
    // Company.php

    public function isFreeQuotaActive()
    {
        return $this->free_post_quota > 0
            && $this->free_post_quota_used < $this->free_post_quota
            && $this->free_post_quota_expired_at
            && now()->lt($this->free_post_quota_expired_at);
    }

    public function startFreeQuotaIfNotYet()
    {
        if (!$this->free_post_quota_expired_at) {
            $this->free_post_quota_expired_at = now()->addDays(7);
            $this->save();
        }
    }

    public function packageOrders()
    {
        return $this->hasMany(EmployerPackageOrder::class);
    }


    public function useFreeQuota()
    {
        $this->increment('free_post_quota_used');
    }

    public function getFreeQuotaRemain()
    {
        if (!$this->isFreeQuotaActive())
            return 0;
        return $this->free_post_quota - $this->free_post_quota_used;
    }

    public function employer()
    {
        return $this->user();
    }
    // Company.php
public function getLogoUrlAttribute()
{
    $logo = $this->attributes['logo_url'] ?? null;

    if (!$logo) {
        return asset('assets/img/default-logo.png');
    }

    // Nếu là URL thì trả thẳng
    if (filter_var($logo, FILTER_VALIDATE_URL)) {
        return $logo;
    }

    // Nếu là đường dẫn trong storage
    if (\Storage::disk('public')->exists($logo)) {
        return asset('storage/' . $logo);
    }

    return asset('assets/img/default-logo.png');
}





}
