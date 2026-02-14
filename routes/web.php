<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// Import Controllers
use App\Http\Controllers\HomeController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\OrderController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;

// 1. Authentication Routes (បិទ Verify)
Auth::routes(['verify' => false]);

// 2. Main Entry Point
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/home', [HomeController::class, 'index']);

// 3. គ្រប់ Route ដែលត្រូវការ Login (តែមិនត្រូវការ Verify Email)
Route::middleware(['auth'])->group(function () {

    // --- ផ្នែកទូទៅ (Profile & Shop) ---
    Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile/avatar', [ProfileController::class, 'deleteAvatar'])->name('profile.avatar.delete');

    // --- ផ្នែក Cashier ---
    Route::middleware(['role:cashier'])->prefix('cashier')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'cashier'])->name('cashier.dashboard');
    });

    // --- ផ្នែក Admin ---
    Route::middleware(['role:admin'])->prefix('admin')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'admin'])->name('admin.dashboard');
    });

    // --- ផ្នែក Owner (Master Access) ---
    Route::middleware(['role:owner'])->prefix('owner')->group(function () {
        Route::get('/dashboard', [DashboardController::class, 'owner'])->name('owner.dashboard');
        Route::get('/users', [UserController::class, 'index'])->name('owner.users');
        Route::post('/users', [UserController::class, 'store'])->name('owner.users.store');
        Route::delete('/users/{id}', [UserController::class, 'destroy'])->name('owner.users.delete');
    });

    // --- ការគ្រប់គ្រងទំនិញ (Staff Access) ---
    Route::middleware(['role:owner,admin,cashier'])->prefix('manage')->group(function () {
        Route::resource('products', ProductController::class);
    });

    // --- ប្រព័ន្ធកន្ត្រក និងការទូទាត់ ---
    Route::post('/cart/add', [ShopController::class, 'addToCart'])->name('cart.add');
    Route::delete('/cart/remove/{id}', [ShopController::class, 'removeFromCart'])->name('cart.remove');
    Route::get('/checkout', [OrderController::class, 'checkout'])->name('checkout');
    Route::post('/payment/confirm', [OrderController::class, 'confirmPayment'])->name('payment.confirm');
    Route::get('/invoice/{id}', [OrderController::class, 'invoice'])->name('invoice');
    Route::get('/my-orders', [OrderController::class, 'history'])->name('orders.history');
});