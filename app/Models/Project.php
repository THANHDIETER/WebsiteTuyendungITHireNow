<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'user_id',
        'project_name',
        'start_date',
        'end_date',
        'description',
        'project_link',
    ];

    // Quan hệ với user
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
