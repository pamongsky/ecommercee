<?php

use Illuminate\Support\Facades\Route;

Route::middleware(['web', 'auth', 'admin'])
    ->prefix('admin')
    ->name('admin.')
    ->group(function () {
        Route::get('/dashboard', fn () => view('admin.dashboard'))->name('dashboard');
        Route::redirect('/', '/admin/dashboard'); // opsional, aman
        Route::resource('products', \App\Http\Controllers\Admin\ProductController::class);
        Route::resource('categories', \App\Http\Controllers\Admin\CategoryController::class);
        Route::get('/dashboard', [\App\Http\Controllers\Admin\DashboardController::class, 'index'])
    ->name('dashboard');
    


    });
