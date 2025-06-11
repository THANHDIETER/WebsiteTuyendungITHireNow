<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class EmployerServicePackage extends Model
{
    protected $fillable = [
        'employer_id', 'package_name', 'start_date', 'end_date', 'status',
    ];

    public function employer()
    {
        return $this->belongsTo(User::class, 'employer_id');
    }
}
