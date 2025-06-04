<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

require __DIR__ . '/admin.php';
require __DIR__ . '/employer.php';
require __DIR__ . '/jobseeker.php';

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/showLoginForm', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [LoginController::class, 'login'])->name('post-login');

Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [LoginController::class, 'callback'])->name('auth.callback');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/docs', fn() => view('docs.index'));

Route::get('/', function(){
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












