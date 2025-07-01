<?php

use App\Http\Controllers\NotificationController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\NotificationController;
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
    // profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::get('profile-dashboard', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');
    Route::get('profile/my-jobs', [ProfileController::class, 'myJobs'])->name('profile.my-jobs');
    Route::get('/settings', [ProfileController::class, 'settings'])->name('profile.settings');
    Route::post('/profile/about-me/update', [ProfileController::class, 'updateAboutMe'])
        ->name('profile.about-me.update');
    Route::post('/profile/education', [ProfileController::class, 'updateEducation'])->name('profile.education.update');
    Route::post('/profile/work-experience', [ProfileController::class, 'storeWorkExperience'])->name('profile.work_experience.store');
    Route::get('/profile/skills', [ProfileController::class, 'showSkillsModal'])->name('profile.skills.modal');
    Route::post('/profile/skills', [ProfileController::class, 'storeSkills'])->name('profile.skills.store');
    Route::post('/profile/project', [ProfileController::class, 'storeProject'])->name('profile.project.store');
    Route::post('/profile/certificates', [ProfileController::class, 'storeCertificate'])->name('profile.certificates.store');
    Route::post('/profile/award', [ProfileController::class, 'storeAward'])->name('profile.award.store');
    Route::post('/profile/languages', [ProfileController::class, 'storeLanguage'])->name('profile.languages.store');
});
