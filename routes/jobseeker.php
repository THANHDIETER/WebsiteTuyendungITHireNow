<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobSeeker\ResumeController;

// 🔐 Route dành riêng cho JOB SEEKER
Route::middleware(['auth:sanctum', 'job_seeker'])->group(function () {

});