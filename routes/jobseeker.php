<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSeeker\ResumeController;
 use App\Http\Controllers\JobSearchController;
// 🔐 Route dành riêng cho JOB SEEKER
Route::prefix('jobseeker')
    // ->middleware(['auth:sanctum', 'jobseeker']) 
    // Đảm bảo người dùng đăng nhập và có quyền jobseeker'])
    ->name('jobseeker.')
    ->group(function () {


});