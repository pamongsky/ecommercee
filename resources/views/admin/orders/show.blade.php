@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Detail Pesanan #{{ $order->id }}</h1>
    
    @if(session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-4" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        
        <div class="lg:col-span-2 space-y-6">

            <div class="bg-white shadow overflow-hidden sm:rounded-lg p-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">Rangkuman Pesanan</h3>
                <dl class="grid grid-cols-1 sm:grid-cols-2 gap-x-4 gap-y-4">
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Dibuat Oleh</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->user->name ?? 'User dihapus' }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Tanggal Pesan</dt>
                        <dd class="mt-1 text-sm text-gray-900">{{ $order->created_at->format('d F Y H:i') }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Status Saat Ini</dt>
                        <dd class="mt-1 text-base font-semibold text-gray-900">{{ ucfirst($order->status) }}</dd>
                    </div>
                    <div>
                        <dt class="text-sm font-medium text-gray-500">Grand Total</dt>
                        <dd class="mt-1 text-lg font-bold text-indigo-600">Rp{{ number_format($order->grand_total, 0, ',', '.') }}</dd>
                    </div>
                </dl>
            </div>
            
            <div class="bg-white shadow sm:rounded-lg p-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">Item yang Dipesan</h3>
                <ul class="divide-y divide-gray-200">
                    @foreach ($order->items as $item)
                    <li class="py-4 flex">
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-medium text-gray-900">{{ $item->product->name ?? $item->product_name_snapshot }}</p>
                            <p class="text-sm text-gray-500">Qty: {{ $item->qty }} x Rp{{ number_format($item->price_snapshot, 0, ',', '.') }}</p>
                        </div>
                        <div class="text-sm font-semibold text-gray-900">
                            Rp{{ number_format($item->subtotal, 0, ',', '.') }}
                        </div>
                    </li>
                    @endforeach
                </ul>
            </div>

        </div>

        <div class="lg:col-span-1 space-y-6">
            
            <div class="bg-white shadow sm:rounded-lg p-5">
                <h3 class="text-lg leading-6 font-medium text-gray-900 mb-3">Alamat Pengiriman</h3>
                <address class="text-sm text-gray-900 not-italic">
                    <p class="font-semibold">{{ $order->recipient_name ?? 'N/A' }}</p>
                    <p>{{ $order->phone ?? 'N/A' }}</p>
                    <p>{{ $order->address_text ?? 'Alamat tidak lengkap' }}</p>
                    @if($order->note)
                        <p class="mt-2 text-xs italic text-gray-600">Catatan: {{ $order->note }}</p>
                    @endif
                </address>
            </div>

            <div class="bg-yellow-50 border-l-4 border-yellow-400 p-4 shadow sm:rounded-lg">
                <h3 class="text-lg leading-6 font-medium text-yellow-800 mb-3">Ubah Status Pesanan</h3>
                
                <form action="{{ route('admin.orders.updateStatus', $order) }}" method="POST">
                    @csrf
                    @method('PATCH') 
                    
                    <div class="mb-4">
                        <label for="status" class="block text-sm font-medium text-gray-700">Pilih Status Baru:</label>
                        <select name="status" id="status" required class="mt-1 block w-full py-2 px-3 border border-gray-300 bg-white rounded-md shadow-sm">
                            <option value="">-- Pilih --</option>
                            @foreach (['pending', 'processing', 'shipped', 'completed', 'cancelled'] as $status)
                                <option value="{{ $status }}" @if($order->status == $status) selected @endif>
                                    {{ ucfirst($status) }}
                                </option>
                            @endforeach
                        </select>
                        @error('status') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                    </div>

                    <button type="submit" class="w-full bg-indigo-600 hover:bg-indigo-700 text-white font-bold py-2 px-4 rounded-md">
                        Update Status
                    </button>
                </form>
            </div>

        </div>
    </div>
</div>
@endsection