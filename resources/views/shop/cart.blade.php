<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Keranjang</h2></x-slot>
    <div class="p-6 max-w-4xl mx-auto">
        @if($items->count())
            <div class="space-y-3">
            @foreach($items as $row)
                @php $p = $row['product']; @endphp
                <div class="flex items-center gap-3 bg-white border rounded p-3">
                    <div class="w-16 h-16 overflow-hidden rounded bg-gray-100">
                        @if($p?->image_path)
                            <img src="{{ asset('storage/'.$p->image_path) }}" class="w-full h-full object-cover">
                        @endif
                    </div>
                    <div class="flex-1">
                        <div class="font-semibold">{{ $p->name ?? 'Produk dihapus' }}</div>
                        <div class="text-sm text-gray-500">Rp {{ number_format($p?->price ?? 0,0,',','.') }}</div>
                    </div>
                    <form action="{{ route('cart.update',$p?->id ?? 0) }}" method="POST" class="flex items-center gap-2">
                        @csrf @method('PATCH')
                        <input type="number" name="qty" min="1" value="{{ $row['qty'] }}" class="w-20 border rounded px-2 py-1">
                        <button class="px-3 py-1 bg-gray-800 text-white rounded text-sm">Update</button>
                    </form>
                    <form action="{{ route('cart.remove',$p?->id ?? 0) }}" method="POST">
                        @csrf @method('DELETE')
                        <button class="text-red-600 text-sm">Hapus</button>
                    </form>
                </div>
            @endforeach
            </div>
            <div class="mt-6 flex items-center justify-between bg-white border rounded p-4">
                <div>Total: <b>Rp {{ number_format($total,0,',','.') }}</b></div>
                @auth
                    <a href="{{ route('checkout.show') }}" class="px-4 py-2 bg-emerald-600 text-white rounded">Checkout</a>
                @else
                    <a href="{{ route('login') }}" class="px-4 py-2 bg-blue-600 text-white rounded">Login untuk Checkout</a>
                @endauth
            </div>
        @else
            <div class="text-gray-500">Keranjang masih kosong.</div>
        @endif
    </div>
</x-app-layout>
