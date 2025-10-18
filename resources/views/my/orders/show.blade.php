<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Detail Pesanan #') . $order->id }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Umum</h3>
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
                        <div>
                            <p class="text-sm text-gray-500">Status:</p>
                            <span class="px-3 py-1 text-sm font-semibold rounded-full 
                                @if($order->status == 'processing') bg-yellow-100 text-yellow-800
                                @elseif($order->status == 'completed') bg-green-100 text-green-800
                                @else bg-red-100 text-red-800 @endif">
                                {{ ucfirst($order->status) }}
                            </span>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">Tanggal Pesanan:</p>
                            <p class="font-medium text-gray-800">{{ $order->created_at->format('d M Y, H:i') }}</p>
                        </div>
                        <div>
                            <p class="text-sm text-gray-500">TOTAL AKHIR:</p>
                            <p class="text-2xl font-extrabold text-indigo-600">Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                        </div>
                    </div>
                    
                    <h3 class="text-lg font-bold mt-6 mb-4 border-b pb-2">Alamat Pengiriman</h3>
                    <p class="text-gray-700">{{ $order->shipping_address ?? 'Alamat belum tersedia saat checkout' }}</p>

                    <h3 class="text-lg font-bold mt-8 mb-4 border-b pb-2">Detail Produk</h3>
                    <div class="space-y-4">
                        @foreach ($order->orderItems as $item)
                            <div class="flex items-center border p-3 rounded-lg bg-gray-50">
                                @if($item->product && $item->product->image)
                                <img src="{{ asset('storage/' . $item->product->image) }}" alt="{{ $item->product->name }}" class="w-16 h-16 object-cover rounded mr-4">
                                @else
                                <div class="w-16 h-16 bg-gray-200 rounded mr-4 flex items-center justify-center text-xs">No Image</div>
                                @endif
                                <div class="flex-grow">
                                    <p class="font-semibold text-gray-900">{{ $item->product->name ?? 'Produk Dihapus' }}</p>
                                    <p class="text-sm text-gray-600">Harga Satuan: Rp{{ number_format($item->price, 0, ',', '.') }}</p>
                                </div>
                                <div class="text-right">
                                    <p class="text-md font-bold text-gray-700">{{ $item->quantity }}x</p>
                                    <p class="text-sm text-gray-500">Subtotal: Rp{{ number_format($item->price * $item->quantity, 0, ',', '.') }}</p>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    <div class="mt-8">
                        <a href="{{ route('my.orders.index') }}" class="text-gray-600 hover:text-gray-800 font-medium flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path></svg>
                            Kembali ke Riwayat Pesanan
                        </a>
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>