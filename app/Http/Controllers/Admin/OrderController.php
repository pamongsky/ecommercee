<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Order; // Model Order yang dibuat oleh A
// use App\Models\User; // Dihapus karena tidak digunakan langsung

class OrderController extends Controller
{
    /**
     * Menampilkan daftar semua pesanan dengan filter status.
     */
    public function index(Request $r)
    {
        // Daftar status yang mungkin
        $statuses = ['pending', 'processing', 'shipped', 'completed', 'cancelled'];
        
        // Ambil status dari query string
        $statusFilter = $r->query('status');

        // Query pesanan
        $orders = Order::with('user')
            // Filter berdasarkan status jika statusFilter ada
            ->when($statusFilter, fn($q) => $q->where('status', $statusFilter))
            ->latest()
            ->paginate(12)
            ->withQueryString();

        return view('admin.orders.index', compact('orders', 'statuses', 'statusFilter'));
    }

    /**
     * Menampilkan detail pesanan tunggal.
     */
    public function show(Order $order)
    {
        // Load relasi: item pesanan, produk terkait, dan user
        $order->load('items.product', 'user');

        return view('admin.orders.show', compact('order'));
    }

    /**
     * Memperbarui status pesanan.
     */
    public function updateStatus(Request $r, Order $order)
    {
        // Validasi input status
        $r->validate([
            'status' => 'required|in:pending,processing,shipped,completed,cancelled'
        ]);

        // Perbarui status di database
        $order->update(['status' => $r->status]);

        // Beri notifikasi sukses dan kembali
        return back()->with('success', 'Status pesanan berhasil diperbarui menjadi ' . ucfirst($r->status) . '.');
    }
}