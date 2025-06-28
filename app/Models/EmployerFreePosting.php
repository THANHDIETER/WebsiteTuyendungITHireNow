<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class EmployerFreePosting extends Model
{
    use HasFactory;

    protected $table = 'employer_free_postings'; // khai báo tên bảng nếu không theo chuẩn Laravel

    protected $fillable = [
        'company_id',
        'post_limit',
        'post_used',
        'reset_at',
    ];

    protected $dates = ['reset_at']; // để Laravel xử lý kiểu date đúng

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
}
