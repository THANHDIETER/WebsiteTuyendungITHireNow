<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class InterviewResponse extends Model
{
    protected $fillable = ['interview_id', 'jobseeker_id', 'response', 'note'];

    public function interview()
    {
        return $this->belongsTo(Interview::class);
    }

    public function jobseeker()
    {
        return $this->belongsTo(User::class, 'jobseeker_id');
    }
}
