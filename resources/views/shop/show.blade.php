<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">
            <a href="{{ route('shop.index') }}" class="text-blue-600 hover:underline">Katalog</a>
            <span class="text-gray-400">/</span> {{ $product->name }}
        </h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4"> 
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Oops! Ada masalah:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 grid md:grid-cols-2 gap-6">
                    <div class="border rounded p-4">
                        @if($product->image_path)
                            <img src="{{ asset('storage/'.$product->image_path) }}" alt="{{ $product->name }}" class="w-full h-auto object-cover rounded">
                        @else
                            <div class="w-22 h-22 flex items-center justify-center bg-gray-100 rounded">
                                <span class="text-gray-400">Tidak ada gambar</span>
                            </div>
                        @endif
                    </div>
        
                    <div class="space-y-3">
                        <h1 class="text-2xl font-bold">{{ $product->name }}</h1>
                        <div class="text-gray-500">Kategori: {{ $product->category->name }}</div>
                        <div class="text-2xl font-bold">Rp {{ $product->price_formatted }}</div>
                        <div class="{{ $product->stock>0 ? 'text-green-600' : 'text-red-600' }}">Stok: {{ $product->stock }}</div>
                        
                        @if ($product->stock > 0)
                            <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                @csrf
                                <div class="my-4">
                                    <label for="qty" class="text-sm font-medium">Jumlah:</label>
                                    <input type="number" name="qty" id="qty" value="1" min="1" 
                                           max="{{ $product->stock }}" 
                                           class="w-20 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500">
                                </div>
                                <button type="submit" 
                                        class="mt-2 px-6 py-2 bg-blue-600 text-white font-semibold rounded-lg shadow-md hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                                    + Tambah ke Keranjang
                                </button>
                            </form>
                        @else
                            <div class="mt-4">
                                <span class="px-6 py-2 bg-gray-400 text-white font-semibold rounded-lg cursor-not-allowed">
                                    Stok Habis
                                </span>
                            </div>
                        @endif
                    </div>
                </div>
            </div> </div>
    </div>
</x-app-layout>