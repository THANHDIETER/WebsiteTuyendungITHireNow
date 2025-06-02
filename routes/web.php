<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;

require __DIR__ . '/admin.php';
require __DIR__ . '/employer.php';
require __DIR__ . '/jobseeker.php';


Route::get('/', fn() => view('auth/login'));

Route::post('/post-login', [LoginController::class, 'login'])->name('post-login');
Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('post-login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');
Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [LoginController::class, 'callback'])->name('auth.callback');

Route::get('/docs', function () {
    return view('docs.index');
});
