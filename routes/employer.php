<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employer\JobController;

Route::get('/employer/jobs', [JobController::class, 'index']);
