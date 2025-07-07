<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\BankLogController;
use App\Http\Controllers\Api\BankSyncController;
use App\Http\Controllers\Api\ApiPaymentController;
use App\Http\Controllers\Api\BankAccountController;

use App\Http\Controllers\Api\Admin\PaymentController as AdminPaymentController;
use App\Http\Controllers\Api\Admin\SeekerProfileController;
use App\Http\Controllers\Admin\DashboardController;

use App\Http\Controllers\Api\EmployerJobApiController;
use App\Http\Controllers\Api\Employer\JobApplicationController as EmployerJobAppController;

// ✅ Lấy thông tin người dùng đã đăng nhập (dành cho debug hoặc xác thực client)
Route::middleware('auth:sanctum')->get('/user', fn(Request $request) => $request->user());


// 🔐 Đăng ký & Đăng nhập (API công khai)
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);


// 🛡️ Nhóm route dành cho ADMIN
Route::prefix('admin')
    ->middleware(['auth:sanctum', 'admin'])
    ->group(function () {
        // Thanh toán
        Route::get('payments/{id}/pdf', [AdminPaymentController::class, 'downloadPdf']);
        Route::apiResource('payments', AdminPaymentController::class);

        // Quản lý hồ sơ ứng viên
        Route::apiResource('seeker-profiles', SeekerProfileController::class);

        // Tài khoản ngân hàng và nhật ký ngân hàng
        Route::apiResource('bank-accounts', BankAccountController::class);
        Route::get('/bank-logs', [BankLogController::class, 'index']);
    });


// 📊 Thống kê admin (không có middleware cụ thể trong bản gốc)
Route::prefix('admin/stats')->group(function () {
    Route::get('/users',        [DashboardController::class, 'userStats']);        // Thống kê người dùng
    Route::get('/jobs',         [DashboardController::class, 'jobStats']);         // Thống kê việc làm
    Route::get('/applications', [DashboardController::class, 'applicationStats']); // Thống kê ứng tuyển
});


// 💼 Nhóm route dành cho EMPLOYER (nhà tuyển dụng)
Route::prefix('employer')->group(function () {
    // Lấy danh sách công việc (không cần đăng nhập)
    Route::get('/jobs', [EmployerJobApiController::class, 'index']);

    // Nhóm route cần đăng nhập với role employer
    Route::middleware(['auth:sanctum', 'employer'])->group(function () {
        // CRUD ứng tuyển từ ứng viên
        Route::apiResource('job-applications', EmployerJobAppController::class);
    });
});


// 🔄 Route dành cho xử lý tự động (cron hoặc background jobs)
Route::get('/check-pending-payments', [ApiPaymentController::class, 'handlePending']); // Kiểm tra giao dịch chờ
Route::get('/sync-bank',              [BankSyncController::class, 'sync']);            // Đồng bộ ngân hàng
