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
    BankAccountController,
    EmployerController,
    BlogController,
    LogoController,
    AiConfigController,
    SeoSettingController,
};
use App\Http\Controllers\Admin\SeekerProfileController;

// 📌 Các route dành riêng cho Admin
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin'])
    ->name('admin.')
    ->group(function () {

        // 🎯 Dashboard + Stats
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats/users', [DashboardController::class, 'userStats'])->name('stats.users');
        Route::get('/stats/jobs', [DashboardController::class, 'jobStats'])->name('stats.jobs');
        Route::get('/stats/applications', [DashboardController::class, 'applicationStats'])->name('stats.applications');

        // ⚙️ Settings
        Route::prefix('settings')->name('settings.')->group(function () {
            Route::get('/', [SettingController::class, 'index'])->name('index');
            Route::post('/', [SettingController::class, 'storeOrUpdate'])->name('save');
            Route::delete('/{setting}', [SettingController::class, 'destroy'])->name('delete');
            Route::post('/defaults', [SettingController::class, 'restoreDefaults'])->name('defaults');
        });

        // 📄 Jobs
        Route::prefix('jobs')->name('jobs.')->controller(JobController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('/{job}', 'show')->name('show');
            Route::post('/{job}/approve', 'approve')->name('approve');
            Route::post('/{job}/reject', 'reject')->name('reject');
            Route::post('/{job}/revert', 'revertToPending')->name('revert');
            Route::delete('/{job}', 'destroy')->name('destroy');
        });

        // 🧰 Service Packages
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

        // 📥 Reports
        Route::resource('reports', ReportController::class)->only(['index', 'show', 'update', 'destroy']);

        // 📑 CV / Applications
        Route::prefix('seekerprofile')->controller(SeekerProfileController::class)->group(function () {
            Route::get('/', 'index')->name('seekerprofile.index');
        });

        // 💳 Payments & Banks
        Route::prefix('payment')->controller(PaymentController::class)->group(function () {
            Route::get('/', 'index')->name('payment.index');
        });
        Route::prefix('bank_account')->controller(BankAccountController::class)->group(function () {
            Route::get('/', 'index')->name('bank_account.index');
        });
        Route::prefix('bank_log')->controller(BankLogController::class)->group(function () {
            Route::get('/', 'index')->name('bank_log.index');
        });

        // 🔔 Quản lý thông báo hệ thống
         Route::prefix('notifications')->name('notifications.')->controller(NotificationController::class)->group(function () {
            // ✅ JSON detail cho DatabaseNotification (đặt TRƯỚC '{id}')
            Route::get('{id}/json', 'json')->name('json');

            Route::get('/', 'index')->name('index');
            Route::get('/create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('{id}', 'show')->name('show');
            Route::get('{id}/edit', 'edit')->name('edit');
            Route::put('{id}', 'update')->name('update');
            Route::delete('{id}', 'destroy')->name('destroy');

            // ✅ Mark one DatabaseNotification as read (dropdown click)
            Route::post('{id}/read', 'markRead')->name('read');

            // ✅ Mark ALL DatabaseNotifications as read (nút "Đánh dấu tất cả đã đọc")
            Route::post('read-all', 'markAllRead')->name('readAll');
        });

        Route::get('logos', [LogoController::class, 'index'])->name('logos.index');
        Route::post('logos/update/{type}', [LogoController::class, 'updateSingle'])->name('logos.updateSingle');
        Route::post('/logos/update-all', [LogoController::class, 'updateAll'])->name('logos.updateAll');

        Route::prefix('blogs')->name('blogs.')->controller(BlogController::class)->group(function () {
            Route::get('/', 'index')->name('index');
            Route::get('create', 'create')->name('create');
            Route::post('/', 'store')->name('store');
            Route::get('{blog}', 'show')->name('show');
            Route::get('{blog}/edit', 'edit')->name('edit');
            Route::put('{blog}', 'update')->name('update');
            Route::delete('{blog}', 'destroy')->name('destroy');
        });

        Route::prefix('employers')->name('employers.')->group(function () {
            Route::get('/', [EmployerController::class, 'index'])->name('index');           // danh sách
            Route::get('/create', [EmployerController::class, 'create'])->name('create');    // form thêm
            Route::post('/', [EmployerController::class, 'store'])->name('store');           // lưu thêm
            Route::get('/{id}', [EmployerController::class, 'show'])->name('show');          // xem chi tiết
            Route::get('/{id}/edit', [EmployerController::class, 'edit'])->name('edit');     // form sửa
            Route::put('/{id}', [EmployerController::class, 'update'])->name('update');      // lưu sửa
            Route::delete('/{id}', [EmployerController::class, 'destroy'])->name('destroy'); // xóa mềm
        });
         Route::get('ai-configs', [AiConfigController::class, 'index'])->name('ai-configs.index');
        Route::post('ai-configs/update-all', [AiConfigController::class, 'updateAll'])->name('ai-configs.updateAll');
        Route::get('/seo-setting', [SeoSettingController::class, 'index'])->name('seo.index');
        Route::post('/seo-setting', [SeoSettingController::class, 'update'])->name('seo.update');
    
    
    });
