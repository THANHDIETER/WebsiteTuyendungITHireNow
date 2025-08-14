<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employers\JobController;
use App\Http\Controllers\Employers\CompanyController;
use App\Http\Controllers\Employers\PackageController;
use App\Http\Controllers\Employers\PaymentController;
use App\Http\Controllers\Employers\DashboardController;
use App\Http\Controllers\Employers\NotificationController;
use App\Http\Controllers\Employers\SubscriptionController;
use App\Http\Controllers\Employers\JobApplicationController;

Route::middleware(['auth', 'employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {

        // Dashboard
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

        // Jobs
        Route::get('/jobs', [JobController::class, 'index'])->name('jobs.index');
        Route::get('/jobs/create', [JobController::class, 'create'])->name('jobs.create');
        Route::post('/jobs', [JobController::class, 'store'])->name('jobs.store');
        Route::get('/jobs/{id}', [JobController::class, 'show'])->name('jobs.show');
        Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');
        Route::patch('/jobs/{id}/close', [JobController::class, 'close'])->name('jobs.close');

        // Applications
        Route::get('/jobs_applications', [JobApplicationController::class, 'index'])->name('jobs.applications');

        // Packages / Payments
        Route::get('/packages', [PackageController::class, 'index'])->name('packages.index');
        Route::get('/packages/{id}', [PackageController::class, 'show'])->name('packages.show');
        Route::get('/packages/{id}/buy', [PackageController::class, 'purchase'])->name('packages.purchase');
        Route::post('/packages/{package}/subscribe', [PackageController::class, 'subscribe'])->name('packages.subscribe');
        Route::get('/payments/{id}', [PaymentController::class, 'show'])->name('payment.show');
        Route::get('/payments/{payment}/check', [PaymentController::class, 'checkStatus'])->name('payments.check');
        Route::delete('/payments/{payment}', [PaymentController::class, 'cancel'])->name('payments.cancel');

        // Companies
        Route::resource('/companies', CompanyController::class)->parameters(['companies' => 'id']);

        // 📌 Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');

        // 🔹 Đọc tất cả (nút "Đánh dấu tất cả đã đọc")
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
            ->name('notifications.readAll');

        // 🔹 Đọc 1 thông báo
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        // ✅ JSON chi tiết 1 notification (fallback realtime)
        Route::get('/notifications/{id}/json', [NotificationController::class, 'showJson'])
            ->name('notifications.json');
    });
