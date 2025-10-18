<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Order;


class MyOrderController extends Controller
{
    public function index(){
        $orders = Order::where('user_id', auth()->id())->latest()->paginate(10);
        return view('shop.my-orders', compact('orders'));
    }
    public function show(Order $order){
        abort_unless($order->user_id===auth()->id(), 403);
        $order->load('items');
        return view('shop.my-order-show', compact('order'));
    }

}
