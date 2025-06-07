<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    protected $table = 'jobs';
    protected $primaryKey = 'id';
    protected $fillable = ['employer_id', 'title', 'description', 'requirements', 'benefits', 'salary', 'location', 'job_type', 'experience_level', 'education_level', 'skills_required', 'deadline', 'status', 'created_at', 'updated_at'];
    public $timestamps = true;
}
