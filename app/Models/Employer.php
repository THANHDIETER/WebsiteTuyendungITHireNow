<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Employer extends Model
{
    protected $table = 'employer';
    protected $primaryKey = 'id';
    protected $fillable = ['username', 'password', 'email', 'company_name', 'company_description', 'company_logo', 'company_address', 'company_phone', 'company_website', 'company_size', 'company_industry', 'company_founded_year', 'company_benefits', 'company_culture', 'company_mission', 'company_vision', 'company_values', 'status', 'created_at', 'updated_at'];
    public $timestamps = true;
}
