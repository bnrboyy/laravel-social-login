<?php

use App\Http\Controllers\FacebookController;
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

Route::get('/', function () {
    return view('welcome');
});

Route::get('/login', function () {
    return view('pages.auth.login');
})->name('login');

Route::get('/register', function () {
    return view('pages.auth.register');
})->name('register');

Route::get('/checkurl', [FacebookController::class, 'getURL']);

// Facebook Login URL
Route::prefix('facebook')->name('facebook.')->group( function () {
    Route::get('auth', [FacebookController::class, 'loginFacebook'])->name('login');
    Route::get('callback', [FacebookController::class, 'callbackFacebook'])->name('callback');
});
