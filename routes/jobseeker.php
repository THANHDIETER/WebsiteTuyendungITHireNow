<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\InterviewController;
use App\Http\Controllers\JobSearchController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\JobSeeker\ResumeController;
use App\Http\Controllers\InterviewResponseController;

// 🔐 Route dành riêng cho JOB SEEKER



// profile routes
Route::middleware(['auth'])->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::get('/notifications/{id}', [NotificationController::class, 'show'])->name('notifications.show');

    // 📩 Xem chi tiết lời mời phỏng vấn
    Route::get('/interviews/{interview}', [InterviewController::class, 'show'])
        ->name('interviews.show');

    // 📩 Phản hồi thư mời phỏng vấn
    Route::post('/interviews/{interview}/respond', [InterviewResponseController::class, 'store'])
        ->name('interviews.respond');

    // Hiển thị và cập nhật hồ sơ
    Route::get('/profile', [ProfileController::class, 'show'])->name('profile.show');
    Route::post('/profile/update', [ProfileController::class, 'update'])->name('profile.update');
    Route::post('/profile/change-password', [ProfileController::class, 'changePassword'])->name('profile.change-password');

    Route::get('profile/my-jobs/{job_slug}', [ProfileController::class, 'viewJob'])->name('profile.view-job');


    // Dashboard & việc làm của tôi
    Route::get('/profile-dashboard', [ProfileController::class, 'dashboard'])->name('profile.dashboard');
    Route::get('/profile/my-jobs', [ProfileController::class, 'myJobs'])->name('profile.my-jobs');

    // Cài đặt

    Route::get('/settings', [ProfileController::class, 'settings'])->name('profile.settings');

    // About Me & trình độ học vấn
    Route::post('/profile/about-me/update', [ProfileController::class, 'updateAboutMe'])->name('profile.about-me.update');
    Route::post('/profile/education', [ProfileController::class, 'updateEducation'])->name('profile.education.update');

    // Kinh nghiệm làm việc
    Route::post('/profile/work-experience', [ProfileController::class, 'storeWorkExperience'])->name('profile.work_experience.store');

    // Kỹ năng
    Route::get('/profile/skills', [ProfileController::class, 'showSkillsModal'])->name('profile.skills.modal');
    Route::post('/profile/skills', [ProfileController::class, 'storeSkills'])->name('profile.skills.store');

    // Dự án
    Route::post('/profile/project', [ProfileController::class, 'storeProject'])->name('profile.project.store');

    // Chứng chỉ
    Route::post('/profile/certificates', [ProfileController::class, 'storeCertificate'])->name('profile.certificates.store');

    // Giải thưởng
    Route::post('/profile/award', [ProfileController::class, 'storeAward'])->name('profile.award.store');

    // Ngôn ngữ
    Route::post('/profile/languages', [ProfileController::class, 'storeLanguage'])->name('profile.languages.store');
});

Route::middleware(['job_seeker'])->group(function () {
    Route::get('/chatchat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{id}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{id}', [ChatController::class, 'send'])->name('chat.send');
    Route::get('/chat/start/{userId}', [ChatController::class, 'start'])->name('chat.start');
    Route::post('/chat/{conversation}/typing', [ChatController::class, 'typing'])->name('chat.typing');
});

