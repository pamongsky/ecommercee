<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Middleware\IsAdmin; 
// WAJIB: Controller yang dipanggil di routes/web.php
use App\Http\Controllers\CartController; // 🔥 TAMBAHKAN INI (Asumsi Tugas Orang A)
use App\Http\Controllers\OrderController as UserOrderController; // 🔥 TAMBAHKAN INI (Asumsi Tugas Orang C)


// ===============================================
// 1. ROUTE DASHBOARD REDIRECT (Sudah ada di kode Anda)
// ===============================================
Route::get('/dashboard', function () {
    // sudah login & verified
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')      // admin -> admin dashboard
        : redirect()->route('shop.index');          // user -> katalog
})->middleware(['auth', 'verified'])->name('dashboard');

// ===============================================
// 2. ROUTE USER PROFILE (Sudah ada di kode Anda)
// ===============================================
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// ===============================================
// 3. ROUTE SHOP/KATALOG (Sudah ada di kode Anda)
// ===============================================
Route::get('/', [ShopController::class, 'index'])->name('shop.index');       // katalog
Route::get('/p/{product:slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/p/{product}', [ShopController::class, 'show'])->name('shop.show')->withoutMiddleware('auth'); // Asumsi p/{product} bisa diakses tanpa login


// ===============================================
// 4. ROUTE GROUP ADMIN (KODE BARU UNTUK ORDERS)
// ===============================================
Route::middleware(['auth', 'verified', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    // Dashboard Admin
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');

    // START: ADMIN ORDERS (PEKERJAAN ANDA)
    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class,'updateStatus'])->name('orders.updateStatus');
    // END: ADMIN ORDERS

});


// ===============================================
// 6. 🔥 ROUTE KERANJANG (CART) - (PEKERJAAN ORANG A)
// ===============================================
// Middleware 'auth' biasanya TIDAK digunakan di sini karena Cart bisa diisi Guest User
Route::prefix('cart')->name('cart.')->group(function () {
    // FIX: Route cart.index yang menyebabkan error
    Route::get('/', [CartController::class, 'index'])->name('index'); 

    // Route Keranjang lainnya (asumsi)
    // Route::post('add/{product}', [CartController::class, 'add'])->name('add');
    // Route::patch('update/{item}', [CartController::class, 'update'])->name('update');
    // Route::delete('remove/{item}', [CartController::class, 'remove'])->name('remove');
});


// ===============================================
// 7. 🔥 ROUTE PESANAN SAYA (MY ORDERS) - (PEKERJAAN ORANG C)
// ===============================================
// Harus menggunakan middleware 'auth' karena hanya user yang sudah login yang bisa melihat pesanan mereka.
Route::middleware(['auth', 'verified'])->prefix('my')->name('my.')->group(function () {
    // Route my.orders.index
    Route::get('orders', [UserOrderController::class, 'index'])->name('orders.index');
    // Route my.orders.show
    Route::get('orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    
    // Asumsi: Route untuk Checkout & Payment (Tugas Orang A)
    // Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    // Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});


// ===============================================
// 8. ROUTE AUTENTIKASI (Sudah ada di kode Anda)
// ===============================================
require __DIR__.'/auth.php';