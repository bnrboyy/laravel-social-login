<?php

use App\Http\Controllers\FacebookController;
use App\Http\Controllers\GoogleController;
use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

Route::get('/checkurl', [FacebookController::class, 'getURL']);

// Facebook Login URL
Route::prefix('facebook')->name('facebook.')->group(function () {
    Route::get('auth', [FacebookController::class, 'loginFacebook'])->name('login');
    Route::get('callback', [FacebookController::class, 'callbackFacebook'])->name('callback');
});

Route::prefix('google')->name('google.')->group(function () {
    Route::get('auth', [GoogleController::class, 'loginGoogle'])->name('login');
    Route::get('callback', [GoogleController::class, 'callbackGoogle'])->name('callback');
});

Route::middleware(['guest'])->group(function () {
    Route::get('/login', function () {
        return view('pages.auth.login');
    })->name('login');
});

Route::middleware(['auth:web'])->group(function () {
    Route::get('/home', function () {
        return view('welcome');
    })->name('home');
    Route::get('logout', [UserController::class, 'logout'])->name('logout');
});
