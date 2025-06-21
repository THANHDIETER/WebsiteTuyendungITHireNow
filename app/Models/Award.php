<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Award extends Model
{
    protected $fillable = [
        'user_id',
        'award_name',
        'organization',
        'start_date',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
