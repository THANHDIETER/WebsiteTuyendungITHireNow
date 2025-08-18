<?php 
namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SeekerCV extends Model
{
    protected $fillable = ['seeker_profile_id', 'file_path', 'title'];

    public function profile(): BelongsTo
    {
        return $this->belongsTo(SeekerProfile::class, 'seeker_profile_id');
    }
}
