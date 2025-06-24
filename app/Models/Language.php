<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Language extends Model
{
    protected $fillable = [
        'user_id',
        'language_name',
        'proficiency_level',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
