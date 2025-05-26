<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Admin extends Model
{
    protected $table = 'admin';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password', 'email', 'full_name', 'phone', 'address', 'avatar', 'status', 'created_at', 'updated_at'];
    public $timestamps = true;
}
