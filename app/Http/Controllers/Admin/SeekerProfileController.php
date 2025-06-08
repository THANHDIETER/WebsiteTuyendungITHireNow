<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SeekerProfileController extends Controller
{
    public function index()
    {
        $title = 'Admin seeker-profiles';
        return view('admin.seekerprofile.index',compact('title'));
    }
}
