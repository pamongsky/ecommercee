<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // 1) Validasi input biar aman & ada default
        $data = $request->validate([
            'q'        => 'nullable|string|max:100',
            'category' => 'nullable|exists:categories,id',
            'sort'     => 'nullable|in:latest,price_asc,price_desc',
            'per_page' => 'nullable|integer|min:6|max:48',
        ]);

        $q         = $data['q']        ?? null;
        $categoryId= $data['category'] ?? null;
        $sort      = $data['sort']     ?? 'latest';
        $perPage   = $data['per_page'] ?? 12;

        // 2) Query: eager load & pilih kolom seperlunya
        $query = Product::query()
            ->with(['category:id,name'])
            ->select(['id','name','price','stock','image_path','category_id','is_active','created_at'])
            ->where('is_active', true)
            ->when($q, fn ($qr) => $qr->where('name', 'like', "%{$q}%"))
            ->when($categoryId, fn ($qr) => $qr->where('category_id', $categoryId));

        // 3) Sorting fleksibel
        $query = match ($sort) {
            'price_asc'  => $query->orderBy('price', 'asc'),
            'price_desc' => $query->orderBy('price', 'desc'),
            default      => $query->latest(),
        };

        // 4) Pagination + pertahankan query string
        $products   = $query->paginate($perPage)->withQueryString();
        $categories = Category::orderBy('name')->get(['id','name']);

        return view('shop.index', [
            'products'   => $products,
            'categories' => $categories,
            'q'          => $q,
            'categoryId' => $categoryId,
            'sort'       => $sort,
            'perPage'    => $perPage,
        ]);
    }

    public function show(Product $product)
    {
        // 5) Jangan tampilkan produk non-aktif
        abort_unless($product->is_active, 404);

        // 6) Eager load kategori pada detail
        $product->load(['category:id,name']);

        // 7) Produk terkait (aktif & beda id)
        $related = Product::query()
            ->select(['id','name','price','image_path','category_id','is_active','created_at'])
            ->where('is_active', true)
            ->where('category_id', $product->category_id)
            ->whereKeyNot($product->id)
            ->latest()
            ->take(4)
            ->get();

        return view('shop.show', compact('product', 'related'));
    }
}