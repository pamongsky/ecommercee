<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Katalog Produk</h2>
    </x-slot>

    <div class="p-6 space-y-4">
        {{-- Filter & Search --}}
        <form method="GET" action="{{ route('shop.index') }}" class="flex gap-2">
            <input
                type="text"
                name="q"
                placeholder="Cari produk..."
                value="{{ $q ?? request('q') }}"
                class="border p-2 rounded w-full"
            >
            <select name="category" class="border p-2 rounded">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(($categoryId ?? request('category')) == $c->id)>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>
            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded">
                Filter
            </button>
        </form>

        {{-- Grid Produk --}}
        @if($products->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $p)
                    <div class="border rounded hover:shadow transition p-3">
                        <a
                          {{-- Opsi A: pakai binding model --}}
                          href="{{ route('shop.show', $p) }}"
                          {{-- Opsi B: pakai id -> href="{{ route('shop.show', ['product' => $p->id]) }}" --}}
                          class="block"
                        >
                            {{-- Kotak gambar rasio 1:1 --}}
                            <div class="w-full aspect-square bg-gray-100 overflow-hidden rounded">
                                @if($p->image_path)
                                    <img
                                        src="{{ asset('storage/'.$p->image_path) }}"
                                        alt="{{ $p->name }}"
                                        class="w-full h-full object-cover"
                                        loading="lazy"
                                    >
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-gray-400 text-sm">
                                        Tidak ada gambar
                                    </div>
                                @endif
                            </div>

                            <div class="mt-3 font-semibold line-clamp-2">{{ $p->name }}</div>
                            <div class="text-sm text-gray-500">{{ $p->category->name }}</div>
                            <div class="mt-1 font-bold">Rp {{ $p->price_formatted }}</div>
                            <div class="text-xs text-gray-500">Stok: {{ $p->stock }}</div>
                        </a>

                        {{-- (Opsional) tombol tambah ke keranjang --}}
                        <form action="{{ route('cart.add', $p) }}" method="POST" class="mt-3">
                            @csrf
                            <button class="w-full px-3 py-2 bg-emerald-600 hover:bg-emerald-700 text-white rounded text-sm">
                                + Keranjang
                            </button>
                        </form>
                    </div>
                @endforeach
            </div>

            {{-- Pagination + bawa query filter --}}
            <div class="mt-4">
                {{ $products->appends(request()->only('q','category'))->links() }}
            </div>
        @else
            <p class="text-gray-500">Produk tidak ditemukan.</p>
        @endif
    </div>
</x-app-layout>
