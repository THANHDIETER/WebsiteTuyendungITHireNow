<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\{
    JobController,
    UserController,
    ReportController,
    BankLogController,
    PaymentController,
    SettingController,
    DashboardController,
    NotificationController,
    ServicePackageController,
    BankAccountControlle,
    EmployerController,
    BlogController
};
use App\Http\Controllers\Admin\SeekerProfileController;

// 📌 Các route dành riêng cho Admin
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin']) // Yêu cầu đăng nhập và có vai trò admin
    ->name('admin.')
    ->group(function () {

        // 🎯 Trang chính (Dashboard + Thống kê)
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats/users', [DashboardController::class, 'userStats'])->name('stats.users');
        Route::get('/stats/jobs', [DashboardController::class, 'jobStats'])->name('stats.jobs');
        Route::get('/stats/applications', [DashboardController::class, 'applicationStats'])->name('stats.applications');

        // ⚙️ Cấu hình hệ thống
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/', [SettingController::class, 'storeOrUpdate'])->name('save');
            Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('delete');
            Route::post('/defaults', [SettingController::class, 'restoreDefaults'])->name('defaults');
        });

        // 📄 Duyệt & quản lý việc làm
        Route::prefix('jobs')->name('jobs.')->controller(JobController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{job}', 'show')->name('show');
            Route::post('/{job}/approve', 'approve')->name('approve');
            Route::post('/{job}/reject', 'reject')->name('reject');
            Route::post('/{job}/revert', 'revertToPending')->name('revert');
            Route::delete('/{job}', 'destroy')->name('destroy');
        });

        // 🧰 Gói dịch vụ
        Route::prefix('service-packages')->name('service-packages.')->controller(ServicePackageController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('{service_package}', 'show')->name('show');
            Route::get('{service_package}/edit', 'edit')->name('edit');
            Route::put('{service_package}', 'update')->name('update');
            Route::delete('{service_package}', 'destroy')->name('destroy');
        });

        // 👤 Quản lý người dùng
        Route::prefix('users')->name('users.')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('{user}', 'show')->name('show');
            Route::get('{user}/edit', 'edit')->name('edit');
            Route::put('{user}', 'update')->name('update');
            Route::delete('{user}', 'destroy')->name('destroy');
        });

        // 📥 Báo cáo vi phạm
        Route::resource('reports', ReportController::class)->only(['index', 'show', 'update', 'destroy']);

        // 📑 Sơ yếu lý lịch (CV)
        Route::prefix('seekerprofile')->controller(SeekerProfileController::class)->group(function () {
            Route::get('/', 'index')->name('seekerprofile.index');
        });

        // 💳 Thanh toán & tài khoản ngân hàng
        Route::prefix('payment')->controller(PaymentController::class)->group(function () {
            Route::get('/', 'index')->name('payment.index');
        });

        Route::prefix('bank_account')->controller(BankAccountControlle::class)->group(function () {
            Route::get('/', 'index')->name('bank_account.index');
        });

        Route::prefix('bank_log')->controller(BankLogController::class)->group(function () {
            Route::get('/', 'index')->name('bank_log.index');
        });

        // 🔔 Quản lý thông báo hệ thống
        Route::get('notifications/{id}/json', [NotificationController::class, 'getJson'])
                ->name('notifications.json');
        Route::resource('notifications', NotificationController::class);
        Route::prefix('employers')->name('employers.')->group(function () {
            Route::get('/', [EmployerController::class, 'index'])->name('index');           // danh sách
            Route::get('/create', [EmployerController::class, 'create'])->name('create');    // form thêm
            Route::post('/', [EmployerController::class, 'store'])->name('store');           // lưu thêm
            Route::get('/{id}', [EmployerController::class, 'show'])->name('show');          // xem chi tiết
            Route::get('/{id}/edit', [EmployerController::class, 'edit'])->name('edit');     // form sửa
            Route::put('/{id}', [EmployerController::class, 'update'])->name('update');      // lưu sửa
            Route::delete('/{id}', [EmployerController::class, 'destroy'])->name('destroy'); // xóa mềm
        });
        Route::resource('logos', App\Http\Controllers\Admin\LogoController::class)->names('logos');

        Route::prefix('blogs')->name('blogs.')->controller(BlogController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('{blog}', 'show')->name('show');
            Route::get('{blog}/edit', 'edit')->name('edit');
            Route::put('{blog}', 'update')->name('update');
            Route::delete('{blog}', 'destroy')->name('destroy');
        });
    });
