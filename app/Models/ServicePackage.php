<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ServicePackage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'description', 'price', 'duration_days', 'post_limit',
        'highlight_days', 'cv_view_limit', 'support_level', 'sort_order', 'is_active',
    ];
}
