<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Application extends Model
{
    protected $table = 'application';
    protected $primaryKey = 'id';
    protected $fillable = ['job_id', 'jobseeker_id', 'cover_letter', 'status', 'created_at', 'updated_at'];
    public $timestamps = true;
}
