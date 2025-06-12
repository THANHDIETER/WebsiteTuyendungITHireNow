<?php

namespace App\Http\Controllers\Employers;
use App\Http\Controllers\Controller;

class JobApplicationController extends Controller
{
    public function index()
    {
        return view('employer.JobApplication.index');
    }

    
}