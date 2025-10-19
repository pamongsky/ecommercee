<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\Admin\OrderController;
use App\Http\Middleware\IsAdmin; 
use App\Http\Controllers\OrderController as UserOrderController; 

use App\Http\Controllers\CartController; 
use App\Http\Controllers\CheckoutController;


Route::get('/dashboard', function () {
    // sudah login & verified
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')      // admin -> admin dashboard
        : redirect()->route('shop.index');          // user -> katalog
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [ShopController::class, 'index'])->name('shop.index');       // katalog
Route::get('/p/{product:slug}', [ShopController::class, 'show'])->name('shop.show');
Route::get('/p/{product}', [ShopController::class, 'show'])->name('shop.show')->withoutMiddleware('auth'); // Asumsi p/{product} bisa diakses tanpa login


Route::prefix('cart')->group(function () {
    Route::get('/', [CartController::class,'index'])->name('cart.index');
    Route::post('/add/{product}', [CartController::class,'add'])->name('cart.add');
    Route::patch('/{product}', [CartController::class,'update'])->name('cart.update');
    Route::delete('/{product}', [CartController::class,'remove'])->name('cart.remove');
    Route::delete('/', [CartController::class,'clear'])->name('cart.clear');
});

Route::middleware('auth')->group(function () {
    Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');
    Route::get('/order/success/{order}', [CheckoutController::class,'success'])->name('checkout.success');
});


Route::middleware(['auth', 'verified', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    Route::get('/orders', [OrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [OrderController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [OrderController::class,'updateStatus'])->name('orders.updateStatus');
    // END: ADMIN ORDERS

});


Route::prefix('cart')->name('cart.')->group(function () {
    // FIX: Route cart.index yang menyebabkan error
    Route::get('/', [CartController::class, 'index'])->name('index'); 

    // Route Keranjang lainnya (asumsi)
    // Route::post('add/{product}', [CartController::class, 'add'])->name('add');
    // Route::patch('update/{item}', [CartController::class, 'update'])->name('update');
    // Route::delete('remove/{item}', [CartController::class, 'remove'])->name('remove');
});


Route::middleware(['auth', 'verified'])->prefix('my')->name('my.')->group(function () {
    // Route my.orders.index
    Route::get('orders', [UserOrderController::class, 'index'])->name('orders.index');
    // Route my.orders.show
    Route::get('orders/{order}', [UserOrderController::class, 'show'])->name('orders.show');
    
    // Asumsi: Route untuk Checkout & Payment (Tugas Orang A)
    // Route::get('checkout', [CheckoutController::class, 'index'])->name('checkout.index');
    // Route::post('checkout', [CheckoutController::class, 'store'])->name('checkout.store');
});


require __DIR__.'/auth.php';