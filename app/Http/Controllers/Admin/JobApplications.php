<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;

class JobApplications extends Controller
{
    public function index()
    {
        $title = 'Admin JobApplications';
        return view('admin.job_applications.index', compact('title'));
    }
}
