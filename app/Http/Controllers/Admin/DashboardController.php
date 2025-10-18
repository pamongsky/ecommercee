<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // Ambil 5 produk terbaru (ikut kategori)
        $products = Product::with('category')->latest()->take(5)->get();

        return view('admin.dashboard', compact('products'));
    }
    
}
