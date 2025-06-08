<?php


use Illuminate\Routing\Router;

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\JobController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\PaymentController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\admin\SeekerProfileController;


use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Admin\ServicePackageController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Middleware\AdminMiddleware;




// Các route dành riêng cho Admin
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin']) 
    // Đảm bảo người dùng đăng nhập và có quyền admin
    ->name('admin.')
    ->group(function () {

        // Trang dashboard
        Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
        Route::get('/stats/users', [DashboardController::class, 'userStats'])->name('stats.users');
        Route::get('/stats/jobs', [DashboardController::class, 'jobStats'])->name('stats.jobs');
        Route::get('/stats/applications', [DashboardController::class, 'applicationStats'])->name('stats.applications');

        // Duyệt tin tuyển dụng việc làm (jobs)
        Route::prefix('jobs')->controller(JobController::class)->group(function () {
            Route::get('/', [JobController::class, 'index'])->name('jobs.index');
            Route::get('/{job}', [JobController::class, 'show'])->name('jobs.show');
            Route::post('/{job}/approve', [JobController::class, 'approve'])->name('jobs.approve');
            Route::post('/{job}/reject', [JobController::class, 'reject'])->name('jobs.reject');
            Route::delete('/{job}', [JobController::class, 'destroy'])->name('jobs.destroy');
        });
        // Quản lý gói dịch vụ (service packages)
        Route::prefix('service-packages')->name('service-packages.')->controller(ServicePackageController::class)->group(function () {
            Route::get('/', 'index')->name('index');                         // Danh sách gói
            Route::get('create', 'create')->name('create');                  // Form tạo mới
            Route::post('/', 'store')->name('store');                        // Xử lý tạo mới
            Route::get('{service_package}/detail', 'show')->name('show');    // Chi tiết gói
            Route::get('{service_package}/edit', 'edit')->name('edit');      // Form sửa
            Route::put('{service_package}', 'update')->name('update');       // Xử lý cập nhật
            Route::delete('{service_package}', 'destroy')->name('destroy');  // Xoá
        });



        // Quản lý người dùng
        Route::prefix('users')->controller(UserController::class)->group(function () {
            Route::get('/', 'index')->name('users.index');
            Route::get('{id}', 'show')->name('users.show');
            Route::patch('{id}/update', 'update')->name('users.update');
            Route::delete('{id}', 'destroy')->name('users.destroy');
        });
        // Route CRUD cho users
        Route::prefix('users')->name('users.')->group(function () {
            Route::get('/', [UserController::class, 'index'])->name('index');
            Route::get('create', [UserController::class, 'create'])->name('create');
            Route::post('/', [UserController::class, 'store'])->name('store');
            Route::get('{user}', [UserController::class, 'show'])->name('show');
            Route::get('{user}/edit', [UserController::class, 'edit'])->name('edit');
            Route::put('{user}', [UserController::class, 'update'])->name('update');
            Route::delete('{user}', [UserController::class, 'destroy'])->name('destroy');

        });
        Route::resource('reports', ReportController::class)
        ->only(['index', 'show', 'update', 'destroy']);

        // trang sơ yếu lý dịch (cv)

        Route::prefix('seekerprofile')->controller(SeekerProfileController::class)->group(function(){
            Route::get('/', 'index')->name('seekerprofile.index');
        });

         Route::prefix('payment')->controller(PaymentController::class)->group(function(){
            Route::get('/', 'index')->name('payment.index');
            });
        Route::prefix('resumes')->controller(ResumeController::class)->group(function () {
            Route::get('/', 'index')->name('resumes.index');

        });


        // Quản lý thống báo

        Route::get('/notifications/create', [NotificationController::class, 'create'])->name('notifications.create');
        Route::post('/notifications', [NotificationController::class, 'store'])->name('notifications.store');
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');
        Route::get('/notifications/{id}/edit', [NotificationController::class, 'edit'])->name('notifications.edit');
        Route::put('/notifications/{id}', [NotificationController::class, 'update'])->name('notifications.update');
        Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');

       

    });
