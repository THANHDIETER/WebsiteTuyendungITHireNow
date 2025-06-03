<?php

use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', fn() => view('auth/login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [LoginController::class, 'login'])->name('post-login');



// Route Giao Dien


Route::get('/trang-chu', function(){
    return view('website.index');
});

Route::get('/cong-viec', function(){
    return view('website.jobs.job');
});

Route::get('/chi-tiet-cong-viec', function(){
    return view('website.jobs.job-details');
});

Route::get('/chi-tiet-nhan-vien', function(){
    return view('website.employers.employe-details');
});

Route::get('/ung-vien', function(){
    return view('website.candidate.candidate');
});

Route::get('/chi-tiet-ung-vien', function(){
    return view('website.candidate.candidate-details');
});

Route::get('/blog', function(){
    return view('website.blog.blog');
});

Route::get('/blog-details', function(){
    return view('website.blog.blog-details');
});

Route::get('/blog-grid', function(){
    return view('website.blog.blog-grid');
});

Route::get('/blog-right-sidebar', function(){
    return view('website.blog.blog-right-sidebar');
});

Route::get('/contact', function(){
    return view('website.pages.contact');
});

Route::get('/404', function(){
    return view('website.pages.404');
});

Route::get('/about-us', function(){
    return view('website.pages.about-us');
});

Route::get('/login', function(){
    return view('website.login-register.login');
});

Route::get('/registration', function(){
    return view('website.login-register.registration');
});



// Route::get('/', function () {
//     return view('welcome');
// });

Route::get('/', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('post-login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [LoginController::class, 'callback'])->name('auth.callback');

Route::get('/docs', fn() => view('docs.index'));

Route::get('/docs', function () {
    return view('docs.index');
});

Route::prefix('admin')->middleware(['auth:sanctum', 'throttle:10,1', 'admin'])->group(function () {
    Route::get('/list-resumes', function () {
    return view('admin.resumes.index');
    })->name('list-resumes');
    Route::get('/list-user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('list-user');

});

// Route::group([
//     'prefix' => 'admin',
//     'as' => 'admin.',
//     // 'middleware' => 'auth'
// ], function () {
//     Route::get('/list-user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('list-user');
// });


// ======================
// Protected Routes
// ======================

// 🔐 Route dành riêng cho ADMIN
Route::middleware(['auth:sanctum', 'admin'])->group(function () {
    Route::get('/list-user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('list-user');
    require __DIR__ . '/admin.php';
});

// 🔐 Route dành riêng cho EMPLOYER
Route::middleware(['auth:sanctum', 'employer'])->group(function () {
    require __DIR__ . '/employer.php';
});

// 🔐 Route dành riêng cho JOB SEEKER
Route::middleware(['auth:sanctum', 'job_seeker'])->group(function () {
    require __DIR__ . '/jobseeker.php';
});

