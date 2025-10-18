<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;


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

Route::get('/my/orders', [\App\Http\Controllers\MyOrderController::class, 'index'])->name('my.orders.index');
Route::get('/my/orders/{order}', [\App\Http\Controllers\MyOrderController::class, 'show'])->name('my.orders.show');

require __DIR__.'/auth.php';
