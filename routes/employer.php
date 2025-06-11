<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employers\JobController;
use App\Http\Controllers\Employers\PackageController;
use App\Http\Controllers\Employers\SubscriptionController;

// Route::prefix('employer')
//     // ->middleware(['auth:sanctum', 'employer'])
//     // Đảm bảo người dùng đăng nhập và có quyền employer
//     ->name('employer.')
//     ->group(function () {

//         // Trang dashboard
//         Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//     });



// 🔐 Route dành riêng cho EMPLOYER

Route::middleware(['auth:sanctum', 'employer'])->group(function () {
    Route::get('/cong-viec', function () {
        return view('website.jobs.job');
    });
    
});

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
 Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::post('packages/{package}/subscribe', [PackageController::class, 'subscribe'])->name('packages.subscribe');
    Route::get('subscriptions', [SubscriptionController::class, 'index'])->name('subscriptions.index');
});

Route::prefix('employer/subscriptions')->middleware('auth')->group(function () {
    Route::get('/', [SubscriptionController::class, 'index'])->name('employer.subscriptions.index');
    Route::get('/{id}', [SubscriptionController::class, 'show'])->name('employer.subscriptions.show');
    Route::get('/{id}/renew', [SubscriptionController::class, 'renew'])->name('employer.subscriptions.renew');
});
