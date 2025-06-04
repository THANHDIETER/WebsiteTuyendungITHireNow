<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\JobApiController;
use App\Http\Controllers\api\Admin\resumeApiController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::prefix('admin')->middleware(['auth:sanctum','throttle:10,1', 'admin'])->group(function () {
    Route::apiResource('/resumes', resumeApiController::class)->only(['index', 'update', 'destroy']);

    Route::get('/jobs', [JobApiController::class, 'index'])->name('api.admin.jobs.index');
    Route::patch('/jobs/{id}/approve', [JobApiController::class, 'approve'])->name('api.admin.jobs.approve');
    Route::delete('/jobs/{id}', [JobApiController::class, 'destroy'])->name('api.admin.jobs.destroy');

});



