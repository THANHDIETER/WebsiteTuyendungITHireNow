<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\CompanyBranchController;
use App\Http\Controllers\Employers\JobController;
use App\Http\Controllers\Employers\StatsController;
use App\Http\Controllers\Employers\CompanyController;
use App\Http\Controllers\Employers\PackageController;
use App\Http\Controllers\Employers\PaymentController;
use App\Http\Controllers\Employers\DashboardController;
use App\Http\Controllers\Employers\PackageLogController;
use App\Http\Controllers\Employers\NotificationController;
use App\Http\Controllers\Employers\SubscriptionController;
use App\Http\Controllers\Employers\JobApplicationController;

Route::middleware(['auth', 'employer'])
    ->prefix('employer')
    ->name('employer.')
    ->group(function () {


        Route::get('/dashboard', [StatsController::class, 'index'])->name('dashboard');                        
        Route::get('/dashboard/filter', [StatsController::class, 'filter'])->name('dashboard.filter');
        Route::get('/stats/filter/data', [StatsController::class, 'filterData'])->name('stats.filter.data');

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
        Route::get('/companies', [CompanyController::class, 'index'])->name('companies.index');
        // Tạo mới
        Route::get('/companies/create', [CompanyController::class, 'create'])->name('companies.create');
        Route::post('/companies', [CompanyController::class, 'store'])->name('companies.store');
        // Chi tiết
        Route::get('/companies/{id}', [CompanyController::class, 'show'])->name('companies.show');
        // Sửa
        Route::get('/companies/{id}/edit', [CompanyController::class, 'edit'])->name('companies.edit');
        Route::put('/companies/{id}', [CompanyController::class, 'update'])->name('companies.update');
        // Xóa
        Route::delete('/companies/{id}', [CompanyController::class, 'destroy'])->name('companies.destroy');
        Route::prefix('companies/{company}')->group(function () {
    Route::get('branches', [CompanyBranchController::class, 'index'])->name('company.branches.index');
    Route::get('branches/create', [CompanyBranchController::class, 'create'])->name('company.branches.create');
    Route::post('branches', [CompanyBranchController::class, 'store'])->name('company.branches.store');
    Route::get('branches/{branch}/edit', [CompanyBranchController::class, 'edit'])->name('company.branches.edit');
    Route::put('branches/{branch}', [CompanyBranchController::class, 'update'])->name('company.branches.update');
    Route::delete('branches/{branch}', [CompanyBranchController::class, 'destroy'])->name('company.branches.destroy');
});
        // (Tuỳ chọn) Cập nhật hoặc xoá tin
        Route::get('/jobs/{id}/edit', [JobController::class, 'edit'])->name('jobs.edit');
        Route::put('/jobs/{id}', [JobController::class, 'update'])->name('jobs.update');
        Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('jobs.destroy');

        # Danh sách việc làm của nhà tuyển dụng
        Route::get('/jobs_applications', [JobApplicationController::class, 'index'])->name('jobs.applications');
         // 🔹 Đọc tất cả (nút "Đánh dấu tất cả đã đọc")
        Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])
            ->name('notifications.readAll');

        // 🔹 Đọc 1 thông báo
        Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])
            ->name('notifications.read');

        // ✅ JSON chi tiết 1 notification (fallback realtime)
        Route::get('/notifications/{id}/json', [NotificationController::class, 'showJson'])
            ->name('notifications.json');
        Route::get('/package-logs', [PackageLogController::class, 'index'])
        ->name('package.logs.index');
    });


Route::middleware(['auth', 'employer'])->prefix('employer')->name('employer.')->group(function () {
    Route::get('packages', [PackageController::class, 'index'])->name('packages.index');
    Route::post('packages/{package}/subscribe', [PackageController::class, 'subscribe'])->name('packages.subscribe');


});

Route::prefix('employer/subscriptions')->middleware('auth')->group(function () {
    Route::get('/jobs_applications', [JobApplicationController::class, 'index'])->name('jobs.applications');
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

    });
