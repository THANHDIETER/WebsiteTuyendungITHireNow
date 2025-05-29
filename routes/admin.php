<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\JobController;
use PHPUnit\Framework\Attributes\Group;

Route::prefix('admin')->group(function () {
    // Dashboard route
    Route::get('/', [DashboardController::class, 'index']);

    // Jobs
    Route::prefix('jobs')->controller(JobController::class)->group(function () {
        Route::get('/', 'index')->name('admin.jobs.index');
        Route::patch('{id}/approve', 'approve')->name('admin.jobs.approve');
        Route::delete('{id}', 'destroy')->name('admin.jobs.destroy');
    });

    // Users
    Route::prefix('users')->controller(UserController::class)->group(function () {
        Route::get('/', 'index')->name('admin.users.index');
        Route::get('{id}', 'show')->name('admin.users.show');
        Route::patch('{id}/update', 'update')->name('admin.users.update');
        Route::delete('{id}', 'destroy')->name('admin.users.destroy');
    });
});

