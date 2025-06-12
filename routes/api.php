<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

use App\Http\Controllers\Api\Auth\AuthController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Api\Admin\JobApiController;
use App\Http\Controllers\Api\Admin\PaymentController;
use App\Http\Controllers\Api\EmployerJobApiController;

use App\Http\Controllers\api\Admin\resumeApiController;
use App\Http\Controllers\Api\admin\SeekerProfileController;
use App\Http\Controllers\Api\Employer\JobApplicationController;


Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');



Route::post('/register', [AuthController::class, 'register']);
Route::post('/login',    [AuthController::class, 'login']);

Route::middleware(['auth:sanctum','admin'])->group(function () {
    Route::get('payments/{id}/pdf', [PaymentController::class, 'downloadPdf']);
    Route::apiResource('seeker-profiles', SeekerProfileController::class);
    Route::apiResource('payments', PaymentController::class);
});


Route::prefix('admin/stats')
->middleware([])
->group(function () {
    Route::get('/users', [DashboardController::class, 'userStats']);
    Route::get('/jobs', [DashboardController::class, 'jobStats']);
    Route::get('/applications', [DashboardController::class, 'applicationStats']);

});

Route::prefix('employer')->group(function () {
    Route::get('/jobs', [EmployerJobApiController::class, 'index']);
});
Route::middleware(['auth:sanctum','employer'])->group(function () {
   Route::apiResource('job-applications', JobApplicationController::class);
});