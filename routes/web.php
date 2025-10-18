<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Middleware\IsAdmin; 
use App\Http\Controllers\CartController; 
use App\Http\Controllers\OrderController as UserOrderController; 


// 1. ROUTE DASHBOARD REDIRECT
Route::get('/dashboard', function () {
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')
        : redirect()->route('shop.index');
})->middleware(['auth', 'verified'])->name('dashboard');

// 2. ROUTE USER PROFILE
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// 3. ROUTE SHOP/KATALOG
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/p/{product:slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/p/{product}', [ShopController::class, 'show'])->name('shop.show')->withoutMiddleware('auth');


// 4. ROUTE GROUP ADMIN
Route::middleware(['auth', 'verified', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    // ADMIN ORDERS <-- PEKERJAAN ANDA
    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class,'updateStatus'])->name('orders.updateStatus');
});


// 6. ROUTE KERANJANG (CART)
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index'); 

    // Route Keranjang lainnya (dibiarkan kosong untuk Orang A)
});


// 7. ROUTE PESANAN SAYA (MY ORDERS)
Route::middleware(['auth', 'verified'])->prefix('my')->name('my.')->group(function () {
    Route::get('orders', [UserOrderController::class, 'index'])->name('orders.index');
    Route::get('orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    
    // Route untuk Checkout & Payment (dibiarkan kosong untuk Orang A)
});


// 8. ROUTE AUTENTIKASI
require __DIR__.'/auth.php';