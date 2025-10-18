<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use App\Models\Order;
use App\Models\OrderItem;

class CheckoutController extends Controller
{
    public function show(){
        $cart = collect(session('cart', []));
        abort_if($cart->isEmpty(), 302, '', ['Location'=>route('cart.index')]);
        return view('shop.checkout');
    }

    public function store(Request $r){
        $data = $r->validate([
            'recipient_name'=>'required|string|max:255',
            'phone'=>'required|string|max:30',
            'address_text'=>'required|string',
            'note'=>'nullable|string|max:255',
        ]);

        $cart = collect(session('cart', []));
        if($cart->isEmpty()){ return redirect()->route('cart.index'); }

        // Pindahkan $items->map() KE DALAM try...catch
        
        DB::beginTransaction(); // Mulai Transaksi
        try{
            // --- Blok Pengecekan Stok (Dipindah ke sini) ---
            $items = $cart->map(function($row){
                $p = Product::lockForUpdate()->find($row['product_id']);  // lock stok
                abort_unless($p, 400, 'Produk tidak ditemukan');
                abort_if($p->stock < $row['qty'], 400, 'Stok tidak cukup'); // Error akan ditangkap 'catch'
                return ['p'=>$p, 'qty'=>$row['qty']];
            });
            // --- Akhir Blok Pengecekan Stok ---

            $subtotal = $items->sum(fn($i)=> $i['p']->price * $i['qty']);
            $shipping = 0;
            $order = Order::create([
                'user_id'        => auth()->user()->id, // Diubah dari auth()->id()
                'recipient_name' => $data['recipient_name'],
                'phone'          => $data['phone'],
                'address_text'   => $data['address_text'],
                'note'           => $data['note'] ?? null,
                'subtotal'       => $subtotal,
                'shipping_cost'  => $shipping,
                'grand_total'    => $subtotal + $shipping,
                'status'         => 'pending',
            ]);

            foreach($items as $it){
                $p = $it['p']; $qty = $it['qty'];
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $p->id,
                    'product_name_snapshot' => $p->name,
                    'price_snapshot' => $p->price,
                    'qty' => $qty,
                    'subtotal' => $p->price * $qty,
                ]);
                // kurangi stok
                $p->decrement('stock', $qty);
            }

            DB::commit(); // Simpan perubahan jika semua sukses
            session()->forget('cart'); // Kosongkan keranjang
            
            return redirect()->route('checkout.success', $order)->with('success','Order berhasil dibuat');

        }catch(\Throwable $e){
            DB::rollBack(); // Batalkan semua jika ada error
            // Error "Stok tidak cukup" akan ditangkap di sini
            return back()->withErrors('Checkout gagal: '.$e->getMessage())->withInput();
        }
    }

    public function success(Order $order){
        abort_unless($order->user_id === auth()->user()->id, 403); // Diubah dari auth()->id()
        return view('shop.order-succes', compact('order'));
    }
}