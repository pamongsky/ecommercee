<?php

use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ShopController;


Route::get('/dashboard', function () {
    return view('dashboard'); // biarkan khusus user biasa
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

Route::get('/shop', [ShopController::class, 'index'])->name('shop.index');          // katalog
Route::get('/p/{product:slug}', [ShopController::class, 'show'])->name('shop.show');

Route::get('/p/{product}', [ShopController::class, 'show'])->name('shop.show');


require __DIR__.'/auth.php';
