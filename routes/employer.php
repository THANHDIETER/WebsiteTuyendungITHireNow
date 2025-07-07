<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Employers\JobController;
use App\Http\Controllers\Employers\PackageController;
use App\Http\Controllers\Employers\PaymentController;
use App\Http\Controllers\Employers\DashboardController;
use App\Http\Controllers\Employers\SubscriptionController;
use App\Http\Controllers\Employers\JobApplicationController;

use App\Http\Controllers\Employers\NotificationController;
use App\Http\Controllers\Employers\CompanyController;
// Đảm bảo đã đăng nhập là employer
Route::middleware(['auth:sanctum', 'employer'])->group(function () {




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

Route::middleware(['auth:sanctum', 'employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {

        // Danh sách việc làm của nhà tuyển dụng

        Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

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


        // (Tuỳ chọn) Cập nhật hoặc xoá tin
        Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');


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

Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::post('packages/{package}/subscribe', [PackageController::class, 'subscribe'])->name('packages.subscribe');
});


    // 👉 Thông báo
    Route::get('/employer/notifications', [NotificationController::class, 'index'])->name('employer.notifications.index');
});

// 👉 Route riêng lẻ không cần prefix, nhưng cần auth + employer
Route::middleware(['auth:sanctum', 'employer'])->get('/cong-viec', function () {
    return view('website.jobs.job');
});

