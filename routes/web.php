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
        $totalAdmin = \App\Models\User::where('roles', 'admin')->count();
        $totalUser = \App\Models\User::where('roles', 'user')->count();
        $totalProduk = \App\Models\Product::count();
        $totalOrder = \App\Models\Order::count();
        
        // Income today vs yesterday
        $incomeToday = \App\Models\Order::whereDate('transaction_time', now())->sum('total_price');
        
        // Latest orders
        $latestOrders = \App\Models\Order::with('kasir')->latest('transaction_time')->take(5)->get();

        return view('pages.dashboard', compact('totalAdmin', 'totalUser', 'totalProduk', 'totalOrder', 'incomeToday', 'latestOrders'));
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
    Route::resource('user', UserController::class)->middleware('is_admin');
    Route::resource('product', \App\Http\Controllers\ProductController::class)->middleware('is_admin');
    Route::resource('order', \App\Http\Controllers\OrderController::class)->middleware('is_admin');
});