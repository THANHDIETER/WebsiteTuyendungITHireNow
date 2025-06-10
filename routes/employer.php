<?php

use App\Http\Controllers\Employer\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employers\JobController;

Route::prefix('employer')
    // ->middleware(['auth:sanctum', 'employer'])
    // Đảm bảo người dùng đăng nhập và có quyền employer
    ->name('employer.')
    ->group(function () {

        // Trang dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    });



// 🔐 Route dành riêng cho EMPLOYER
Route::middleware(['auth:sanctum', 'employer'])->prefix('employer')->name('employer.')->group(function () {

    // Danh sách việc làm của nhà tuyển dụng
    Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');

    // Form tạo mới tin tuyển dụng
    Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');

    // Lưu tin tuyển dụng
    Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');

    // Xem chi tiết tin đã đăng
    Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');

    // (Tuỳ chọn) Cập nhật hoặc xoá tin
    Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
    Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');

});

