<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\JobSeeker\ResumeController;
 use App\Http\Controllers\JobSearchController;
// 🔐 Route dành riêng cho JOB SEEKER


Route::middleware(['auth:sanctum', 'job_seeker'])
    ->prefix('job_seeker')
    ->name('job_seeker.')
    ->group(function () {
        // 📌 Notifications
        Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
        // Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
        // Route::delete('/notifications/{id}', [NotificationController::class, 'destroy'])->name('notifications.destroy');
        // Route::post('/notifications/mark-all-read', [NotificationController::class, 'markAllAsRead'])->name('notifications.markAllAsRead');
    });