<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
class Resume extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'file_url',
        'is_approved',
    ];
    public $timestamps = true;


    protected $casts = [
        'is_approved' => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
    
}