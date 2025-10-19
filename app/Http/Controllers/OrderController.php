<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order; // Pastikan Anda mengimpor Model Order

class OrderController extends Controller
{
    /**
     * Menampilkan daftar riwayat pesanan (My Orders) pengguna yang sedang login.
     */
    public function index()
    {
        // Mendapatkan user ID yang sedang login
        $userId = auth()->id();

        // Mengambil semua pesanan (orders) yang dimiliki oleh user ini,
        // urutkan dari yang terbaru (descending)
        $orders = Order::where('user_id', $userId)
                       ->latest()
                       ->paginate(10); // Tambahkan pagination

        return view('my.orders.index', compact('orders'));
    }

    /**
     * Menampilkan detail spesifik dari satu pesanan.
     */
    public function show(Order $order)
    {
        // **KEAMANAN PENTING:** Verifikasi bahwa pesanan ini benar-benar milik user yang login.
        if ($order->user_id !== auth()->id()) {
            // Jika pesanan bukan miliknya, kembalikan 404 (lebih aman daripada 403)
            abort(404);
        }

        // Load relasi order items dan produknya untuk ditampilkan di view
        $order->load('orderItems.product'); 

        return view('my.orders.show', compact('order'));
    }
}