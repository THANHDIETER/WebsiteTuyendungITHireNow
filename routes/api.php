<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;


use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\AdminResumeController;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\JobApiController;

////
use App\Http\Middleware\AuthMiddleware;
use App\Http\Middleware\RoleMiddleware;


Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::prefix('admin')->middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/resumes', [AdminResumeController::class, 'index']);
    Route::patch('/resumes/{id}/approve', [AdminResumeController::class, 'approve']);
    Route::delete('/resumes/{id}/delete', [AdminResumeController::class, 'destroy']);
});


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::middleware('auth:api')->get('/me', function () {
    return response()->json(auth('api')->user());
});


Route::prefix('admin')->middleware(['auth:api', 'admin'])->group(function () {
    Route::get('/jobs', [JobApiController::class, 'index'])->name('api.admin.jobs.index');
    Route::patch('/jobs/{id}/approve', [JobApiController::class, 'approve'])->name('api.admin.jobs.approve');
    Route::delete('/jobs/{id}', [JobApiController::class, 'destroy'])->name('api.admin.jobs.destroy');
});


/////////
Route::prefix('admin')->middleware([AuthMiddleware::class])->group(function () {
    Route::get('/resumes', [AdminResumeController::class, 'index']);
    Route::patch('/resumes/{id}/approve', [AdminResumeController::class, 'approve']);
    Route::delete('/resumes/{id}/delete', [AdminResumeController::class, 'destroy']);

    // Dùng alias 'role:admin' thay cho closure
    Route::middleware('role:admin')->group(function () {
        Route::get('/jobs', [JobApiController::class, 'index'])->name('api.admin.jobs.index');
        Route::patch('/jobs/{id}/approve', [JobApiController::class, 'approve'])->name('api.admin.jobs.approve');
        Route::delete('/jobs/{id}', [JobApiController::class, 'destroy'])->name('api.admin.jobs.destroy');
    });
});
