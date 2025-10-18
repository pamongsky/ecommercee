<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class MyOrderController extends Controller
{
    public function __construct()
    {
        // pastikan hanya user login yang bisa akses
        $this->middleware('auth');
    }

    /**
     * Daftar pesanan milik user yang sedang login.
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->latest()
            ->paginate(10)
            ->withQueryString(); // jaga q/sort tetap nempel kalau ada

        return view('shop.my-orders', compact('orders'));
    }

    /**
     * Detail 1 pesanan milik user.
     */
    public function show(Order $order)
    {
        // cegah akses pesanan milik user lain
        abort_unless($order->user_id === Auth::id(), 403);

        // eager load item agar hemat query
        $order->load([
            'items' => function ($q) {
                $q->select('id','order_id','product_id','product_name_snapshot','price_snapshot','qty','subtotal');
            }
        ]);

        return view('shop.my-order-show', compact('order'));
    }

    // (Opsional) Batalkan pesanan jika masih pending
    // public function cancel(Order $order)
    // {
    //     abort_unless($order->user_id === Auth::id(), 403);
    //     if ($order->status !== 'pending') {
    //         return back()->withErrors('Pesanan tidak dapat dibatalkan.');
    //     }
    //     $order->update(['status' => 'cancelled']);
    //     return back()->with('success', 'Pesanan dibatalkan.');
    // }
}
