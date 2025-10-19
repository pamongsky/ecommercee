<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Pesanan Saya</h2></x-slot>
    <div class="p-6">
        <table class="w-full border">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 border">#</th>
                    <th class="p-2 border">Total</th>
                    <th class="p-2 border">Status</th>
                    <th class="p-2 border">Tanggal</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orders as $order)
                    <tr>
                        <td class="p-2 border">{{ $order->id }}</td>
                        <td class="p-2 border">Rp {{ number_format($order->grand_total,0,',','.') }}</td>
                        <td class="p-2 border">{{ ucfirst($order->status) }}</td>
                        <td class="p-2 border">{{ $order->created_at->format('d M Y H:i') }}</td>
                        <td class="p-2 border">
                            <a href="{{ route('my.orders.show', $order) }}" class="text-blue-600">Lihat</a>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>

        <div class="mt-4">{{ $orders->links() }}</div>
    </div>
</x-app-layout>
