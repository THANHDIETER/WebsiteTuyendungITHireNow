<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    protected $fillable = [
        'user_id',
        'certificate_name',
        'organization',
        'start_date',
        'certificate_link',
        'description',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
