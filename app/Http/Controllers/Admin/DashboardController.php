<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class DashboardController extends Controller
{
    public function index()
    {
        // === LIST PRODUK (jangan diubah; sesuai permintaan) ===
        $products = Product::with('category')->get();

        // === KARTU ANGKA ===
        $productCount = Product::count();

        // Kategori: hitung dari tabel categories jika ada, kalau tidak fallback dari produk.
        $categoryCount = 0;
        if (Schema::hasTable('categories')) {
            $categoryCount = DB::table('categories')->count();
        } else {
            $categoryCount = Product::whereNotNull('category_id')
                ->distinct('category_id')
                ->count('category_id');
        }

        // Pesanan "baru" / menunggu diproses (tahan banting ke berbagai skema)
        $pendingOrders = 0;
        if (Schema::hasTable('orders')) {
            $q = DB::table('orders');

            // cari kolom status yang ada
            if (Schema::hasColumn('orders', 'status')) {
                $pendingOrders = (clone $q)->whereIn(DB::raw('LOWER(`status`)'), [
                    'pending', 'unpaid', 'waiting', 'waiting_payment', 'awaiting_payment',
                    'processing', 'process', 'new', 'menunggu', 'menunggu_pembayaran'
                ])->count();
            } elseif (Schema::hasColumn('orders', 'payment_status')) {
                $pendingOrders = (clone $q)->whereIn(DB::raw('LOWER(`payment_status`)'), [
                    'pending', 'unpaid', 'waiting_payment', 'awaiting_payment'
                ])->count();
            } elseif (Schema::hasColumn('orders', 'is_paid')) {
                $pendingOrders = (clone $q)->where('is_paid', 0)->count();
            } elseif (Schema::hasColumn('orders', 'paid_at')) {
                $pendingOrders = (clone $q)->whereNull('paid_at')->count();
            }
        }

        // Pendapatan bulan ini (anggap hanya yang sudah dibayar)
        $monthlyRevenue = 0;
        if (Schema::hasTable('orders')) {
            $amountCol = collect(['grand_total','total','total_price','amount','price'])
                ->first(fn ($c) => Schema::hasColumn('orders', $c));

            if ($amountCol) {
                $paid = DB::table('orders')->whereMonth('created_at', now()->month);

                if (Schema::hasColumn('orders', 'status')) {
                    $paid->whereIn(DB::raw('LOWER(`status`)'), [
                        'paid','paid_out','settlement','success','completed','selesai','lunas'
                    ]);
                } elseif (Schema::hasColumn('orders', 'payment_status')) {
                    $paid->whereIn(DB::raw('LOWER(`payment_status`)'), [
                        'paid','settlement','success','completed','lunas'
                    ]);
                } elseif (Schema::hasColumn('orders', 'is_paid')) {
                    $paid->where('is_paid', 1);
                } elseif (Schema::hasColumn('orders', 'paid_at')) {
                    $paid->whereNotNull('paid_at');
                }

                $monthlyRevenue = $paid->sum($amountCol);
            }
        }

        return view('admin.dashboard', [
            'products'       => $products,
            'productCount'   => $productCount,
            'categoryCount'  => $categoryCount,
            'pendingOrders'  => $pendingOrders,
            'monthlyRevenue' => $monthlyRevenue,
        ]);
    }
}
