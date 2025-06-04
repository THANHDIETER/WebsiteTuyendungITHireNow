<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobSeeker extends Model
{
    protected $table = 'jobseeker';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password', 'email', 'full_name', 'phone', 'address', 'avatar', 'cv', 'skills', 'experience', 'education', 'status', 'created_at', 'updated_at'];
    public $timestamps = true;
}
