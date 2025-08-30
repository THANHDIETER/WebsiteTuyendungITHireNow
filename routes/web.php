<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Location;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\JobController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ChatBotController;
use App\Http\Controllers\FavoriteController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Cache;

// Load các route tách riêng
require __DIR__ . '/admin.php';
require __DIR__ . '/employer.php';
require __DIR__ . '/jobseeker.php';
require __DIR__ . '/notification.php';
require __DIR__ . '/channels.php';

use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JobApplicationController;
use App\Notifications\NewJobSubmittedNotification;
use App\Http\Controllers\Auth\ResetPasswordController;
use App\Http\Controllers\Auth\ForgotPasswordController;

Route::get('/test-notification', function (Request $request) {
    $user = User::find(2); // user id = 2
    if (!$user) {
        return 'User không tồn tại';
    }

    $message = $request->query('message', "Thông báo mặc định");

    $user->notify(new NewJobSubmittedNotification($message));

    return "Đã gửi notification cho user #{$user->id} với nội dung: {$message}";
});

Route::get('/chatbot/history', [ChatBotController::class, 'history']);
Route::view('/chat', 'chat');
Route::post('/chatbot', [ChatBotController::class, 'chat']);
Route::post('/chat/mark-all-read', [ChatController::class, 'markAllRead'])
    ->name('chat.markAllRead')
    ->middleware('auth');

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register.post');

Route::get('/register/employer', [RegisterController::class, 'showRegisterEmployerForm'])->name('showRegisterEmployerForm');
Route::post('/register/employer', [RegisterController::class, 'registerEmployer'])->name('registerEmployer');

Route::get('/showLoginForm', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [LoginController::class, 'login'])->name('post-login');

Route::get('forgot-password', [ForgotPasswordController::class, 'showLinkRequestForm'])->name('password.request');
Route::post('forgot-password', [ForgotPasswordController::class, 'sendResetLinkEmail'])->name('password.email');

Route::get('reset-password/{token}', [ResetPasswordController::class, 'showResetForm'])->name('password.reset');
Route::post('reset-password', [ResetPasswordController::class, 'reset'])->name('password.update');

Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [LoginController::class, 'callback'])->name('auth.callback');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/docs', fn() => view('docs.index'));

Route::get('website/employer', [LoginController::class, 'employerDetails'])->name('employer.details');


// Static Pages
Route::get('/docs', fn() => view('docs.index'))->name('docs');

Route::get('employer-details', [LoginController::class, 'employerDetails'])->name('employer.details');

// Giao diện người dùng (Website)
Route::get('/job_seeker', function () {
    return view('employer.index');
})->name('cong-viec');

// ================= HOME =================
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/api/jobs', [HomeController::class, 'jobsApi'])->name('api.jobs');

Route::get('/api/locations', function () {
    return Cache::remember('top_locations', now()->addMinutes(60), function () {
        return Location::withCount('jobs')
            ->orderByDesc('jobs_count')
            ->take(6)
            ->get(['id', 'name']);
    });
});


// ================= JOB =================
Route::get('/cong-viec', [JobController::class, 'index'])->name('jobs.index');
Route::get('/cong-viec/tim-kiem', [JobController::class, 'search'])->name('jobs.search'); // <--- Route search mới
Route::get('/cong-viec/{slug}', [JobController::class, 'show'])->name('jobs.show');

// Route::get('/jobs/{job}/apply', [JobApplicationController::class, 'show'])
//         ->name('jobs.showApply');
Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');



// ================= EMPLOYER =================
Route::get('/job_seeker', function () {
    return view('employer.index');
})->name('cong-viec');

Route::get('/employer', function () {
    return view('employer.index');
})->name('employer');

Route::get('/website/employer', [LoginController::class, 'employerDetails'])->name('employer.details');
Route::get('/employer-details', [LoginController::class, 'employerDetails'])->name('employer.details');


// ================= STATIC PAGES =================
Route::get('/docs', function () {
    return view('docs.index');
})->name('docs');

Route::get('/about-us', function () {
    return view('website.pages.about-us');
})->name('about-us');

Route::get('/contact', function () {
    return view('website.pages.contact', [
        'title' => 'Liên lạc'
    ]);
})->name('contact');

Route::get('/404', function () {
    return view('website.pages.404');
})->name('404');


// ================= JOB DETAIL / EMPLOYER DETAIL =================
Route::get('/chi-tiet-cong-viec', function () {
    return view('website.jobs.job-details');
})->name('chi-tiet-cong-viec');

Route::get('/chi-tiet-nhan-vien', function () {
    return view('website.employers.employe-details');
})->name('chi-tiet-nhan-vien');


// ================= CANDIDATES =================
Route::get('/ung-vien', function () {
    return view('website.candidate.candidate');
})->name('ung-vien');

Route::get('/chi-tiet-ung-vien', function () {
    return view('website.candidate.candidate-details');
})->name('chi-tiet-ung-vien');

Route::get('/blog', function () {
    return view('website.blog.blog');
})->name('blog');

Route::get('/blog-details', function () {
    return view('website.blog.blog-details');
})->name('blog-details');

Route::get('/blog-grid', function () {

    return view('website.blog.blog-grid');
})->name('blog-grid');

Route::get('/blog-right-sidebar', function () {
    return view('website.blog.blog-right-sidebar');
})->name('blog-right-sidebar');


// ================= LOGIN / REGISTER UI =================
Route::get('/login', function () {
    return view('website.login-register.login');
});

Route::get('/registration', function () {
    return view('website.login-register.registration');
});


// routes/web.php

