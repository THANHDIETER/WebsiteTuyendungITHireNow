<?php

use App\Http\Controllers\Admin\AdminServicePackageController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\JobController;
use PHPUnit\Framework\Attributes\Group;


// Route::prefix('admin')->middleware('admin')->group(function () {
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

    // Service packages
    Route::prefix('service-packages')->controller(AdminServicePackageController::class)->group(function () {
        Route::get('/', [AdminServicePackageController::class, 'index'])->name('admin.service-packages.index');
        Route::get('/create', [AdminServicePackageController::class, 'create'])->name('admin.service-packages.create');
        Route::post('/', [AdminServicePackageController::class, 'store'])->name('admin.service-packages.store');
        Route::get('/{servicePackage}/edit', [AdminServicePackageController::class, 'edit'])->name('admin.service-packages.edit');
        Route::put('/{servicePackage}', [AdminServicePackageController::class, 'update'])->name('admin.service-packages.update');
        Route::delete('/{servicePackage}', [AdminServicePackageController::class, 'destroy'])->name('admin.service-packages.destroy');
    });
});
