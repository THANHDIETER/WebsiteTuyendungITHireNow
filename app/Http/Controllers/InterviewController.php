<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;    
use Illuminate\Http\Request;
use App\Models\Interview;

class InterviewController extends Controller
{
    /**
     * Hiển thị chi tiết một lời mời phỏng vấn.
     */
    public function show(Interview $interview)
    {
        return view('website.interviews.show', compact('interview'));
    }
}
