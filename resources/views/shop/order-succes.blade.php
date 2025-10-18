<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Pesanan Berhasil</h2>
    </x-slot>
    
    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white border rounded-lg shadow-sm p-6">
                <p class="mb-2 text-gray-800">Terima kasih! Pesanan kamu sudah kami terima.</p>
                <p>No. Order: <b>#{{ $order->id }}</b></p>
                
                <p>Total: <b>Rp {{ number_format($order->grand_total,0,',','.') }}</b></p> 

                <a href="{{ route('shop.index') }}" class="text-blue-600 hover:underline mt-4 inline-block">
                    &larr; Kembali ke Katalog
                </a>
            </div>
        </div>
    </div>
</x-app-layout>