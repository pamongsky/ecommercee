<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

// --- CONTROLLER UMUM ---
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ShopController;
use App\Http\Controllers\CartController;
use App\Http\Controllers\CheckoutController;
use App\Http\Controllers\MyOrderController;

// --- CONTROLLER & MIDDLEWARE ADMIN ---
use App\Http\Controllers\Admin\OrderController as AdminOrderController;
use App\Http\Middleware\IsAdmin;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
*/

// --- ROUTE UTAMA & KATALOG (Publik) ---
Route::get('/', [ShopController::class, 'index'])->name('shop.index');
Route::get('/p/{product:slug}', [ShopController::class, 'show'])->name('shop.show');


// --- ROUTE KERANJANG (Publik) ---
Route::prefix('cart')->name('cart.')->group(function () {
    Route::get('/', [CartController::class,'index'])->name('index');
    Route::post('/add/{product}', [CartController::class,'add'])->name('add');
    Route::patch('/{product}', [CartController::class,'update'])->name('update');
    Route::delete('/{product}', [CartController::class,'remove'])->name('remove');
    Route::delete('/', [CartController::class,'clear'])->name('clear');
});


// --- ROUTE YANG BUTUH LOGIN ---
Route::middleware('auth')->group(function () {
    
    // --- Dashboard Redirect ---
    Route::get('/dashboard', function () {
        return Auth::user()->role === 'admin'
            ? redirect()->route('admin.dashboard')
            : redirect()->route('shop.index');
    })->middleware('verified')->name('dashboard');
    
    // --- Profile User ---
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // --- Checkout & Success Page ---
    Route::get('/checkout', [CheckoutController::class,'show'])->name('checkout.show');
    Route::post('/checkout', [CheckoutController::class,'store'])->name('checkout.store');
    Route::get('/order/success/{order}', [CheckoutController::class,'success'])->name('checkout.success');
    
    // --- Halaman 'Pesanan Saya' (User) ---
    Route::get('/my/orders', [MyOrderController::class, 'index'])->name('my.orders.index');
    Route::get('/my/orders/{order}', [MyOrderController::class, 'show'])->name('my.orders.show');
    
});


// --- ROUTE KHUSUS ADMIN ---
Route::middleware(['auth', 'verified', IsAdmin::class])->prefix('admin')->name('admin.')->group(function () {
    
    Route::view('/dashboard', 'admin.dashboard')->name('dashboard');
    
    // --- Admin: Manajemen Pesanan ---
    Route::get('/orders', [AdminOrderController::class,'index'])->name('orders.index');
    Route::get('/orders/{order}', [AdminOrderController::class,'show'])->name('orders.show');
    Route::patch('/orders/{order}/status', [AdminOrderController::class,'updateStatus'])->name('orders.updateStatus');
    
    // (Tambahkan route admin lainnya di sini jika ada, misal CRUD Produk/Kategori)
    
});


// --- FILE AUTH BAWAAN ---
require __DIR__.'/auth.php';