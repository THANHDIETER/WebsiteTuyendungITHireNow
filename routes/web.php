<?php

use Illuminate\Support\Facades\Route;

require __DIR__ . '/admin.php';
require __DIR__ . '/employer.php';
require __DIR__ . '/jobseeker.php';


Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'showLoginForm']);
Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login']);
Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'showRegisterForm']);
Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register']);

Route::group([
    'prefix' => 'admin',
    'as' => 'admin.',
    // 'middleware' => 'auth'
], function () {
    Route::get('/list-user', [App\Http\Controllers\Admin\UserController::class, 'index']);
});


Route::get('/docs', function () {
    return view('docs.index');
});
