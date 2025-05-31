<?php

use App\Http\Controllers\Auth\LoginController;
use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin.php';
require __DIR__ . '/employer.php';
require __DIR__ . '/jobseeker.php';



Route::get('/', function () {
    return view('auth/login');
});

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm'])->name('showLoginForm');
Route::post('/post-login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('post-login');
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm'])->name('register');
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

Route::get('/auth/redirect', [LoginController::class, 'redirect'])->name('auth.redirect');
Route::get('/auth/callback', [LoginController::class, 'callback'])->name('auth.callback');

Route::get('/list-user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('list-user');


// Route::group([
//     'prefix' => 'admin',
//     'as' => 'admin.',
//     // 'middleware' => 'auth'
// ], function () {
//     Route::get('/list-user', [App\Http\Controllers\Admin\UserController::class, 'index'])->name('list-user');
// });

Route::get('/docs', function () {
    return view('docs.index');
});
