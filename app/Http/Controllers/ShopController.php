<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        // ambil filter/query
        $q = $request->query('q');
        $categoryId = $request->query('category');

        $products = Product::with('category')
            ->when($q, fn($qr) => $qr->where('name','like',"%{$q}%"))
            ->when($categoryId, fn($qr) => $qr->where('category_id', $categoryId))
            ->where('is_active', true)
            ->latest()
            ->paginate(12)
            ->withQueryString();

        $categories = Category::orderBy('name')->get();

        return view('shop.index', compact('products','categories','q','categoryId'));
    }

    public function show(Product $product)
    {
        // produk terkait (kategori sama) 4 item
        $related = Product::where('category_id', $product->category_id)
                    ->where('id','<>',$product->id)
                    ->latest()->take(4)->get();

        return view('shop.show', compact('product','related'));
    }
}
