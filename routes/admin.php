<?php

use App\Http\Controllers\Admin\AdminServicePackageController;
use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Middleware\AdminMiddleware;


// Các route dành riêng cho Admin
Route::prefix('admin')
    // ->middleware(['auth:sanctum', 'admin']) // Đảm bảo người dùng đăng nhập và có quyền admin
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

        // Route CRUD cho users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('{user}', [UserController::class, 'show'])->name('show');
            Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');
        });
        Route::resource('reports', \App\Http\Controllers\Admin\ReportController::class)
        ->only(['index', 'show', 'update', 'destroy']);

        // trang sơ yếu lý dịch (cv)
        Route::prefix('resumes')->controller(ResumeController::class)->group(function () {
            Route::get('/', 'index')->name('resumes.index');
        });

        // Quản lý thống báo

        Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
        Route::put('/notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

    });
