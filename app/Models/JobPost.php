<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobPost extends Model
{
    protected $table = 'job_posts';
    protected $fillable = ['company_id', 'title', 'description', 'is_approved'];
    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function company()
    {
        return $this->belongsTo(Company::class);
    }
    // Vô hiệu hóa timestamps
    public $timestamps = false;
}