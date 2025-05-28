<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;

use App\Http\Controllers\Admin\JobController;

Route::get('/admin', [UserController::class, 'index']);



// Route::prefix('admin')->middleware('admin')->group(function () {
Route::prefix('admin')->group(function () {
    Route::get('/jobs', [JobController::class, 'index'])->name('admin.jobs.index');
    Route::patch('/jobs/{id}/approve', [JobController::class, 'approve'])->name('admin.jobs.approve');
    Route::delete('/jobs/{id}', [JobController::class, 'destroy'])->name('admin.jobs.destroy');
});