<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $fillable = [
        'user_id',
        'position',
        'company_name',
        'start_date',
        'end_date',
        'work_description',
        'project_details',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
