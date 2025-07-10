<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use App\Http\Controllers\BlogController;
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

Route::get('employer-details', [LoginController::class, 'employerDetails'])->name('employer.details');

// Giao diện người dùng (Website)
Route::get('/job_seeker', function () {
    return view('employer.index');
})->name('cong-viec');

Route::get('/', [HomeController::class, 'index'])->name('home');


Route::get('/cong-viec', [JobController::class, 'index'])->name('jobs.index');
Route::get('/cong-viec/{slug}', [JobController::class, 'show'])->name('jobs.show');

Route::get('/employer', function () {
    return view('employer.index');
})->name('employer');


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

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index'); 
Route::get('/blog/{id}', [BlogController::class, 'show'])->name('blog.show'); 
Route::get('/blog-grid', [BlogController::class, 'indexGrid'])->name('blog-grid');
Route::get('/blog-right-sidebar', [BlogController::class, 'indexRightSidebar'])->name('blog.rightSidebar');


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



Route::get('/admin/noti/latest', function () {
    $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

    return response()->json($notifications->map(function ($noti) {
        return [
            'id' => $noti->id,
            'message' => $noti->data['message'],
            'link_url' => $noti->data['link_url'],
            'time' => $noti->created_at->diffForHumans()
        ];
    }));
})->name('admin.notifications.latest');
Route::get('/employer/noti/latest', function () {
    $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

    return response()->json($notifications->map(function ($noti) {
        return [
            'id' => $noti->id,
            'message' => $noti->data['message'],
            'link_url' => $noti->data['link_url'],
            'time' => $noti->created_at->diffForHumans()
        ];
    }));
})->name('employer.notifications.latest');

Route::get('/seeker/notifications/latest', function () {
    $notifications = auth()->user()->unreadNotifications()->latest()->take(5)->get();

    return response()->json($notifications->map(function ($noti) {
        return [
            'id' => $noti->id,
            'message' => $noti->data['message'],
            'link_url' => $noti->data['link_url'],
            'time' => $noti->created_at->diffForHumans(),
        ];
    }));
})->middleware('auth');