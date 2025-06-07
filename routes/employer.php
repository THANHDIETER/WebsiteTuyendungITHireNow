<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employer\JobController;

// 🔐 Route dành riêng cho EMPLOYER
Route::middleware(['auth:sanctum', 'employer'])->group(function () {

});