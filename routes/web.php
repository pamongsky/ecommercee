<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;

use App\Http\Controllers\CartController; 
use App\Http\Controllers\CheckoutController;



Route::get('/dashboard', function () {
    // sudah login & verified
    return Auth::user()->role === 'admin'
        ? redirect()->route('admin.dashboard')   // admin -> admin dashboard
        : redirect()->route('shop.index');       // user -> katalog
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/', [ShopController::class, 'index'])->name('shop.index');          // katalog
Route::get('/p/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/p/{product}', [ShopController::class, 'show'])->name('shop.show');

Route::view('/admin/dashboard', 'admin.dashboard')
    ->middleware(['auth', 'verified'])
    ->name('admin.dashboard');


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



require __DIR__.'/auth.php';
