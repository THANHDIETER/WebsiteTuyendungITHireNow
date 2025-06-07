<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('admin/stats')->group(function () {
    Route::get('/users', [DashboardController::class, 'userStats']);
    Route::get('/jobs', [DashboardController::class, 'jobStats']);
    Route::get('/applications', [DashboardController::class, 'applicationStats']);
});
