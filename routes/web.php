<?php

use App\Http\Controllers\UserController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('pages.auth.login');
});

Route::middleware(['auth'])->group(function () {
    Route::get('home', function () {
        return view('pages.dashboard');
    })->name('home');

    // Profile Routes
    Route::get('/profile', function () {
        return view('profile.index');
    })->name('profile');
    
    Route::get('/profile/activities', function () {
        return view('profile.activities');
    })->name('profile.activities');
    
    Route::get('/profile/settings', function () {
        return view('profile.settings');
    })->name('profile.settings');

    // Resource Routes
    Route::resource('user', UserController::class);
    Route::resource('product', \App\Http\Controllers\ProductController::class);
    Route::resource('order', \App\Http\Controllers\OrderController::class);
});