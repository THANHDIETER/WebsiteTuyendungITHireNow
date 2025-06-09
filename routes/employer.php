<?php

use App\Http\Controllers\Employer\DashboardController;
use Illuminate\Support\Facades\Route;

Route::prefix('employer')
    // ->middleware(['auth:sanctum', 'employer'])
    // Đảm bảo người dùng đăng nhập và có quyền employer
    ->name('employer.')
    ->group(function () {

        // Trang dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });
