<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\JobController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\JobApplicationController;

require __DIR__ . '/admin.php';
require __DIR__ . '/employer.php';
require __DIR__ . '/jobseeker.php';

Route::get('/register', [RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register'])->name('register');

Route::get('/showLoginForm', [LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [LoginController::class, 'login'])->name('post-login');

Route::get('/register/employer', [RegisterController::class, 'showRegisterEmployerForm'])->name('showRegisterEmployerForm');
Route::post('/register/employer', [RegisterController::class, 'registerEmployer'])->name('registerEmployer');

Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [LoginController::class, 'callback'])->name('auth.callback');

Route::get('/logout', [LoginController::class, 'logout'])->name('logout');
Route::get('/docs', fn() => view('docs.index'));

Route::get('website/employer', [LoginController::class, 'employerDetails'])->name('employer.details');

// Static Pages
Route::get('/docs', fn() => view('docs.index'))->name('docs');

Route::get('employer', [LoginController::class, 'employerDetails'])->name('employer.details');

// Giao diện người dùng (Website)
Route::get('/', function () {
    return view('employer.index');
})->name('home');

Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/cong-viec', [JobController::class, 'index'])->name('jobs.index');
Route::get('/cong-viec/{slug}', [JobController::class, 'show'])->name('jobs.show');


Route::get('/cong-vieca', function () {
    return view('website.jobs.job');
})->name('cong-viec');


Route::get('/chi-tiet-cong-viec', function () {
    return view('website.jobs.job-details');
})->name('chi-tiet-cong-viec');

Route::get('/chi-tiet-nhan-vien', function () {
    return view('website.employers.employe-details');
})->name('chi-tiet-nhan-vien');

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

Route::get('/contact', function () {
    return view('website.pages.contact');
})->name('contact');

Route::get('/404', function () {
    return view('website.pages.404');

})->name('404');


Route::get('/about-us', function () {
    return view('website.pages.about-us');
})->name('about-us');

Route::get('/login', function () {
    return view('website.login-register.login');
});

Route::get('/registration', function () {
    return view('website.login-register.registration');

});

Route::post('/jobs/{job}/apply', [JobApplicationController::class, 'store'])->name('jobs.apply');

})->name('registration');


