<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Favorite extends Model
{
    protected $fillable = ['user_id', 'job_id', 'note'];

    // Nếu bạn dùng soft delete
    // use Illuminate\Database\Eloquent\SoftDeletes;
    // use SoftDeletes;

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function job()
    {
        return $this->belongsTo(Job::class);
    }
}
