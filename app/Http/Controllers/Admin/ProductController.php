<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProductController extends Controller
{
    /**
     * LIST PRODUK (admin)
     */
    public function index()
    {
        // ambil produk terbaru + relasi kategori, paginate 10
        $products = Product::with('category')->latest()->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    /**
     * FORM TAMBAH
     */
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.create', compact('categories'));
    }

    /**
     * SIMPAN PRODUK BARU
     */
    public function store(Request $request)
    {
        // validasi input
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|integer|min:0',
            'is_active'   => 'required|boolean',
            'image'       => 'nullable|image|max:2048', // input file harus bernama "image"
        ]);

        // generate slug unik dari nama
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);

        // kalau ada file gambar, simpan ke storage/public/products
        if ($request->hasFile('image')) {
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        Product::create($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil ditambahkan.');
    }

    /**
     * DETAIL (opsional, kalau mau dipakai)
     */
    public function show(Product $product)
    {
        return view('admin.products.show', compact('product'));
    }

    /**
     * FORM EDIT
     */
    public function edit(Product $product)
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.products.edit', compact('product', 'categories'));
    }

    /**
     * UPDATE PRODUK
     */
    public function update(Request $request, Product $product)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stock'       => 'required|integer|min:0',
            'price'       => 'required|integer|min:0',
            'is_active'   => 'required|boolean',
            'image'       => 'nullable|image|max:2048',
        ]);

        // regenerate slug kalau nama berubah (biar URL ikut nama baru)
        $data['slug'] = Str::slug($data['name']) . '-' . Str::random(5);

        if ($request->hasFile('image')) {
            // hapus gambar lama kalau ada
            if ($product->image_path) {
                Storage::disk('public')->delete($product->image_path);
            }
            $data['image_path'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()
            ->route('admin.products.index')
            ->with('success', 'Produk berhasil diupdate.');
    }

    /**
     * HAPUS PRODUK
     */
    public function destroy(Product $product)
    {
        // hapus file gambar kalau ada
        if ($product->image_path) {
            Storage::disk('public')->delete($product->image_path);
        }

        $product->delete();

        return back()->with('success', 'Produk berhasil dihapus.');
    }
}
