<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Katalog Produk</h2>
    </x-slot>

    <div class="p-6 space-y-4">
        {{-- Filter & Search --}}
        <form method="GET" action="{{ route('shop.index') }}" class="flex gap-2">
            <input type="text" name="q" placeholder="Cari produk..."
                   value="{{ $q ?? '' }}" class="border p-2 rounded w-full">
            <select name="category" class="border p-2 rounded">
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" @selected(($categoryId ?? null)==$c->id)>{{ $c->name }}</option>
                @endforeach
            </select>
            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-black rounded">Filter</button>
        </form>

        {{-- Grid Produk --}}
        @if($products->count())
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
                @foreach($products as $p)
                    <a href="{{ route('shop.show', ['product' => $p->id]) }}"
                        class="border rounded hover:shadow transition p-3 block">
                        <div class="h-30 w-30 bg-gray-100 flex items-center justify-center overflow-hidden rounded">
                            @if($p->image_path)
                                <img src="{{ asset('storage/'.$p->image_path) }}"
                                     alt="{{ $p->name }}" class="object-cover h-20 w-20">
                            @else
                                <span class="text-gray-400 text-sm">Tidak ada gambar</span>
                            @endif
                        </div>
                        <div class="mt-2 font-semibold">{{ $p->name }}</div>
                        <div class="text-sm text-gray-500">{{ $p->category->name }}</div>
                        <div class="mt-1 font-bold">Rp {{ $p->price_formatted }}</div>
                    </a>
                @endforeach
            </div>

            <div class="mt-4">
                {{ $products->links() }}
            </div>
        @else
            <p class="text-gray-500">Produk tidak ditemukan.</p>
        @endif
    </div>
</x-app-layout>
