<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Detail Pesanan #{{ $order->id }}</h2></x-slot>
    <div class="p-6 space-y-3">
        <div class="bg-white border rounded p-4">
            <div><b>Status:</b> {{ ucfirst($order->status) }}</div>
            <div><b>Total:</b> Rp {{ number_format($order->grand_total,0,',','.') }}</div>
            <div><b>Alamat:</b> {{ $order->address_text }}</div>
        </div>
        <div class="bg-white border rounded p-4">
            <table class="w-full border">
                <thead class="bg-gray-50"><tr>
                    <th class="p-2 border">Produk</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Qty</th>
                    <th class="p-2 border">Subtotal</th>
                </tr></thead>
                <tbody>
                    @foreach($order->items as $it)
                        <tr>
                            <td class="p-2 border">{{ $it->product_name_snapshot }}</td>
                            <td class="p-2 border">Rp {{ number_format($it->price_snapshot,0,',','.') }}</td>
                            <td class="p-2 border">{{ $it->qty }}</td>
                            <td class="p-2 border">Rp {{ number_format($it->subtotal,0,',','.') }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</x-app-layout>
