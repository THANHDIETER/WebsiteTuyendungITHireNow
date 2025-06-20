<?php

use App\Http\Controllers\Employers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employers\JobController;
use App\Http\Controllers\Employers\PackageController;
use App\Http\Controllers\Employers\SubscriptionController;
use App\Http\Controllers\Employers\JobApplicationController;

// Route::prefix('employer')
//     // ->middleware(['auth:sanctum', 'employer'])
//     // Đảm bảo người dùng đăng nhập và có quyền employer
//     ->name('employer.')
//     ->group(function () {

//         // Trang dashboard
//         Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
//     });



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
    Route::patch('/jobs/{id}/close', [JobController::class, 'close'])->name('jobs.close');

     Route::get('/jobs_applications', [JobApplicationController::class, 'index'])->name('jobs.applications');
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
Route::prefix('employer/packages')->middleware(['auth', 'employer'])->group(function () {
    Route::get('/', [PackageController::class, 'index'])->name('employer.packages.index');
    Route::get('/{id}/buy', [PackageController::class, 'purchase'])->name('employer.packages.purchase');
    Route::post('/{id}/buy', [PackageController::class, 'subscribe'])->name('employer.packages.subscribe');
    Route::get('/{id}', [PackageController::class, 'show'])->name('employer.packages.show'); // tuỳ chọn
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



