<?php

use Illuminate\Routing\Router;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Admin\ServicePackageController;

// Các route dành riêng cho Admin
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin']) // Đảm bảo người dùng đăng nhập và có quyền admin
    ->name('admin.')
    ->group(function () {

        // Trang dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');

        // Duyệt tin tuyển dụng việc làm (jobs)
        Route::prefix('jobs')->controller(JobController::class)->group(function () {
            Route::get('/', [JobController::class, 'index'])->name('jobs.index');
            Route::get('/{job}', [JobController::class, 'show'])->name('jobs.show');
            Route::post('/{job}/approve', [JobController::class, 'approve'])->name('jobs.approve');
            Route::post('/{job}/reject', [JobController::class, 'reject'])->name('jobs.reject');
            Route::delete('/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        });
        // Quản lý gói dịch vụ (service packages)
        Route::prefix('service-packages')->name('service-packages.')->controller(ServicePackageController::class)->group(function () {
            Route::get('/', 'index')->name('index');                         // Danh sách gói
            Route::get('create', 'create')->name('create');                  // Form tạo mới
            Route::post('/', 'store')->name('store');                        // Xử lý tạo mới
            Route::get('{service_package}/detail', 'show')->name('show');    // Chi tiết gói
            Route::get('{service_package}/edit', 'edit')->name('edit');      // Form sửa
            Route::put('{service_package}', 'update')->name('update');       // Xử lý cập nhật
            Route::delete('{service_package}', 'destroy')->name('destroy');  // Xoá
        });


        // Quản lý người dùng
        Route::prefix('users')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('users.index');
            Route::get('{id}', 'show')->name('users.show');
            Route::patch('{id}/update', 'update')->name('users.update');
            Route::delete('{id}', 'destroy')->name('users.destroy');
        });

        // trang sơ yếu lý dịch (cv)
        Route::prefix('resumes')->controller(ResumeController::class)->group(function () {
            Route::get('/', 'index')->name('resumes.index');
        });
    });
