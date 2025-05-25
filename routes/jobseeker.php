<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSeeker\ResumeController;

Route::get('/jobseeker/resumes', [ResumeController::class, 'index']);
