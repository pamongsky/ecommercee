<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Riwayat Pesanan Saya') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 bg-white border-b border-gray-200">
                    
                    @forelse ($orders as $order)
                        <div class="border p-4 mb-4 rounded-lg shadow-md hover:shadow-lg transition duration-150">
                            <div class="flex justify-between items-center">
                                <div>
                                    <p class="text-sm text-gray-500">
                                        ID Pesanan: <span class="font-semibold text-gray-700">#{{ $order->id }}</span>
                                    </p>
                                    <p class="text-sm text-gray-500">
                                        Tanggal: {{ $order->created_at->format('d M Y, H:i') }}
                                    </p>
                                </div>
                                <div class="text-right">
                                    <p class="text-lg font-bold text-gray-900">Total: Rp{{ number_format($order->total, 0, ',', '.') }}</p>
                                    <span class="px-3 py-1 text-xs font-semibold rounded-full 
                                        @if($order->status == 'processing') bg-yellow-100 text-yellow-800
                                        @elseif($order->status == 'completed') bg-green-100 text-green-800
                                        @else bg-red-100 text-red-800 @endif">
                                        {{ ucfirst($order->status) }}
                                    </span>
                                </div>
                            </div>
                            <div class="mt-3 text-right">
                                <a href="{{ route('my.orders.show', $order) }}" class="text-blue-600 hover:text-blue-800 font-medium text-sm">
                                    Lihat Detail &rarr;
                                </a>
                            </div>
                        </div>
                    @empty
                        <p class="text-center text-gray-600">Anda belum memiliki riwayat pesanan.</p>
                    @endforelse

                    <div class="mt-4">
                        {{ $orders->links() }}
                    </div>

                </div>
            </div>
        </div>
    </div>
</x-app-layout>