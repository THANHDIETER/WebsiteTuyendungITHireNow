<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\JobApplication;

class SeekerProfileController extends Controller
{
    public function index()
    {
        $applications = JobApplication::with(['user', 'job', 'company'])->orderByDesc('id')->paginate(10);
        $title = 'Admin seeker-profiles';
        return view('admin.seekerprofile.index',compact('title', 'applications'));
    }
}
