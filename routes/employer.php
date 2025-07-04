<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employers\JobController;
use App\Http\Controllers\Employers\PackageController;
use App\Http\Controllers\Employers\PaymentController;
use App\Http\Controllers\Employers\DashboardController;
use App\Http\Controllers\Employers\SubscriptionController;
use App\Http\Controllers\Employers\JobApplicationController;
use App\Http\Controllers\Employers\NotificationController;

// Đảm bảo đã đăng nhập là employer
Route::middleware(['auth:sanctum', 'employer'])->group(function () {

    // 👉 Trang chủ quản trị
    Route::get('/employer/dashboard', [DashboardController::class, 'index'])->name('employer.dashboard');

    // 👉 Trang công việc
    Route::prefix('employer/jobs')->name('employer.jobs.')->group(function () {
        Route::get('/', [JobController::class, 'index'])->name('index');
        Route::get('/create', [JobController::class, 'create'])->name('create');
        Route::post('/', [JobController::class, 'store'])->name('store');
        Route::get('/{id}', [JobController::class, 'show'])->name('show');
        Route::get('/{id}/edit', [JobController::class, 'edit'])->name('edit');
        Route::put('/{id}', [JobController::class, 'update'])->name('update');
        Route::delete('/{id}', [JobController::class, 'destroy'])->name('destroy');
        Route::patch('/{id}/close', [JobController::class, 'close'])->name('close');
    });

    // 👉 Ứng viên ứng tuyển
    Route::get('/employer/jobs_applications', [JobApplicationController::class, 'index'])->name('employer.jobs.applications');

    // 👉 Gói dịch vụ
    Route::prefix('employer/packages')->name('employer.packages.')->group(function () {
        Route::get('/', [PackageController::class, 'index'])->name('index');
        Route::get('/{id}/buy', [PackageController::class, 'purchase'])->name('purchase');
        Route::post('/{package}/subscribe', [PackageController::class, 'subscribe'])->name('subscribe');
        Route::get('/{id}', [PackageController::class, 'show'])->name('show'); // tùy chọn
    });

    // 👉 Thanh toán
    Route::prefix('employer/payments')->name('employer.payments.')->group(function () {
        Route::get('/{id}', [PaymentController::class, 'show'])->name('show');
        Route::get('/{payment}/check', [PaymentController::class, 'checkStatus'])->name('check');
        Route::delete('/{payment}', [PaymentController::class, 'cancel'])->name('cancel');
    });

    // 👉 Thông báo
    Route::get('/employer/notifications', [NotificationController::class, 'index'])->name('employer.notifications.index');
});

// 👉 Route riêng lẻ không cần prefix, nhưng cần auth + employer
Route::middleware(['auth:sanctum', 'employer'])->get('/cong-viec', function () {
    return view('website.jobs.job');
});
