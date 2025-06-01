<?php

use App\Http\Controllers\Admin\ResumeController;
use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

// Public Routes
Route::get('/', fn() => view('auth/login'));
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [LoginController::class, 'login'])->name('post-login');

Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [LoginController::class, 'callback'])->name('auth.callback');

Route::get('/docs', fn() => view('docs.index'));

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
