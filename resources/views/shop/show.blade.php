<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            <a href="{{ route('shop.index') }}" class="text-blue-600 hover:underline">Katalog</a>
            <span class="text-gray-400">/</span> {{ $product->name }}
        </h2>
    </x-slot>

    <div class="p-6 grid md:grid-cols-2 gap-6">
        <div class="border rounded p-4">
            @if($product->image_path)
                <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-20 h-20 object-cover rounded">
            @else
                <div class="w-20 h-20 flex items-center justify-center bg-gray-100 rounded">
                    <span class="text-gray-400">Tidak ada gambar</span>
                </div>
            @endif
        </div>

        <div class="space-y-3">
            <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
            <div class="text-gray-500">Kategori: {{ $product->category->name }}</div>
            <div class="text-2xl font-bold">Rp {{ $product->price_formatted }}</div>
            <div class="{{ $product->stock>0 ? 'text-green-600' : 'text-red-600' }}">Stok: {{ $product->stock }}</div>
        </div>
    </div>
</x-app-layout>
