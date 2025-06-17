<?php

use App\Http\Controllers\Employers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employers\JobController;
use App\Http\Controllers\Employers\PackageController;
use App\Http\Controllers\Employers\PaymentController;
use App\Http\Controllers\Employers\JobApplicationController;


Route::middleware(['auth:sanctum', 'employer'])->group(function () {
    Route::get('/cong-viec', function () {
        return view('website.jobs.job');
    });

});

Route::middleware(['auth:sanctum', 'employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {

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

        // hồ sơ ứng viên
        Route::get('/jobs_applications', [JobApplicationController::class, 'index'])->name('jobs.applications');
        
        // gói dịch vụ
        Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('/{id}/buy', [PackageController::class, 'purchase'])->name('packages.purchase');
        Route::post('packages/{package}/subscribe', [PackageController::class, 'subscribe'])->name('packages.subscribe');
        
        // thanh toán gói dịch vụ
        Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('/payments/{payment}/check', [PaymentController::class, 'checkStatus'])->name('payments.check');
        Route::delete('/payments/{payment}', [PaymentController::class, 'cancel'])->name('payments.cancel');


    });





Route::middleware(['auth:sanctum', 'employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {
        // 📌 Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        // Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        // Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        // Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    });



