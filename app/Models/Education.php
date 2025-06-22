<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Education extends Model
{
    protected $fillable = [
        'user_id',
        'school_name',
        'major',
        'degree',
        'start_year',
        'end_year',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
