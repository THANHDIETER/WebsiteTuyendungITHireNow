<?php
namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Logo extends Model
{
    protected $fillable = ['name', 'type', 'image_path', 'is_active'];
}
