<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Api\Admin\JobApiController;
use App\Http\Controllers\Api\Admin\PaymentController;
use App\Http\Controllers\api\Admin\resumeApiController;
use App\Http\Controllers\Api\admin\SeekerProfileController;



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware([])->group(function () {
    Route::get('payments/{id}/pdf', [PaymentController::class, 'downloadPdf']);
    Route::apiResource('seeker-profiles', SeekerProfileController::class);
    Route::apiResource('payments', PaymentController::class);
});

Route::prefix('admin')->middleware(['auth:sanctum','throttle:10,1', 'admin'])->group(function () {

    Route::get('/jobs', [JobApiController::class, 'index'])->name('api.admin.jobs.index');
    Route::patch('/jobs/{id}/approve', [JobApiController::class, 'approve'])->name('api.admin.jobs.approve');
    Route::delete('/jobs/{id}', [JobApiController::class, 'destroy'])->name('api.admin.jobs.destroy');

});



