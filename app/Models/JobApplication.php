<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class JobApplication extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'job_id',
        'user_id',
        'company_id',
        'cv_url',
        'cover_letter',
        'applied_at',
        'status',
        'is_shortlisted',
        'source',
        'application_stage',
        'interview_date',
        'note'
    ];

    protected $casts = [
        'applied_at' => 'datetime',
        'interview_date' => 'datetime',
        'is_shortlisted' => 'boolean',
    ];

    // Relationships
    public function job()
    {
        return $this->belongsTo(Job::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function company()
    {
        return $this->belongsTo(Company::class);
    }
<<<<<<< HEAD
}
=======
}
>>>>>>> b9415a3b41f90f6ec4df40f97d47fc6235287f05
