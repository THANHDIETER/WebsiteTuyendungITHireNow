<?php

use App\Http\Controllers\Admin\AdminServicePackageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobController;


// Các route dành riêng cho Admin
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin']) // Đảm bảo người dùng đăng nhập và có quyền admin
    ->name('admin.')
    ->group(function () {

        // Trang dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Quản lý việc làm (jobs)
        Route::prefix('jobs')->controller(JobController::class)->group(function () {
            Route::get('/', 'index')->name('jobs.index');
            Route::patch('{id}/approve', 'approve')->name('jobs.approve');
            Route::delete('{id}', 'destroy')->name('jobs.destroy');
        });

        // Quản lý người dùng
        Route::prefix('users')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('users.index');
            Route::get('{id}', 'show')->name('users.show');
            Route::patch('{id}/update', 'update')->name('users.update');
            Route::delete('{id}', 'destroy')->name('users.destroy');
        });
    });

   
