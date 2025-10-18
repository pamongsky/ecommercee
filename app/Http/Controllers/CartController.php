<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;

class CartController extends Controller
{
    protected function getCart(){ return collect(session('cart', [])); }
    protected function saveCart($cart){ session(['cart' => $cart->toArray()]); }

    public function index(){
        $cart = $this->getCart();
        $items = $cart->map(function($row){
            $p = Product::find($row['product_id']);
            return [
                'product' => $p,
                'qty'     => $row['qty'],
                'subtotal'=> $p ? $p->price * $row['qty'] : 0,
            ];
        });
        $total = $items->sum('subtotal');
        return view('shop.cart', compact('items','total'));
    }

    public function add(Request $req, Product $product){
        $qty = max(1, (int)$req->input('qty',1));
        $cart = $this->getCart();
        $exists = $cart->firstWhere('product_id',$product->id);

        if($exists){
            $cart = $cart->map(function($row) use($product,$qty){
                if($row['product_id']==$product->id){ $row['qty'] += $qty; }
                return $row;
            });
        }else{
            $cart->push(['product_id'=>$product->id,'qty'=>$qty]);
        }
        $this->saveCart($cart);
        return back()->with('success','Produk ditambahkan ke keranjang.');
    }

    public function update(Request $req, Product $product){
        $qty = max(1, (int)$req->input('qty',1));
        $cart = $this->getCart()->map(function($row) use($product,$qty){
            if($row['product_id']==$product->id){ $row['qty'] = $qty; }
            return $row;
        });
        $this->saveCart($cart);
        return back();
    }

    public function remove(Product $product){
        $cart = $this->getCart()->reject(fn($row)=>$row['product_id']==$product->id);
        $this->saveCart($cart);
        return back()->with('success','Item dihapus.');
    }

    public function clear(){
        session()->forget('cart');
        return back()->with('success','Keranjang dikosongkan.');
    }

}
