<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JobLanguage extends Model
{
    protected $table = 'job_languages';
    protected $fillable = ['name', 'is_active'];
    public function jobs()
    {
        return $this->hasMany(Job::class, 'language_id');
    }
    

    
}
