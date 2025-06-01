<?php

use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminResumeController;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\JobApiController;

// ✅ Dùng middleware alias 'admin' bạn đã gán trong app hoặc Kernel
Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

// ✅ Lấy thông tin user sau khi login (Sanctum)
Route::middleware('auth:sanctum')->get('/me', function (Request $request) {
    return response()->json($request->user());
});

// ✅ ADMIN routes bảo vệ bằng Sanctum + middleware admin
Route::prefix('admin')->middleware(['auth:sanctum', 'admin'])->group(function () {

    // Manage Resumes
    Route::get('/resumes', [AdminResumeController::class, 'index']);
    Route::patch('/resumes/{id}/approve', [AdminResumeController::class, 'approve']);
    Route::delete('/resumes/{id}/delete', [AdminResumeController::class, 'destroy']);

    // Manage Jobs
    Route::get('/jobs', [JobApiController::class, 'index'])->name('api.admin.jobs.index');
    Route::patch('/jobs/{id}/approve', [JobApiController::class, 'approve'])->name('api.admin.jobs.approve');
    Route::delete('/jobs/{id}', [JobApiController::class, 'destroy'])->name('api.admin.jobs.destroy');
});
