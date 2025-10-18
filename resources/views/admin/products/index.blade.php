<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Produk</h2></x-slot>

    <div class="p-6">
        <a href="{{ route('admin.products.create') }}"
           class="px-3 py-2 bg-blue-600 hover:bg-blue-700 text-black rounded">
            + Tambah
        </a>

        @if(session('success'))
            <div class="mt-3 bg-green-100 text-green-800 p-3 rounded">{{ session('success') }}</div>
        @endif

        <table class="w-full mt-4 border text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 border">Gambar</th>     {{-- <-- kolom baru --}}
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border">Kategori</th>
                    <th class="p-2 border">Harga</th>
                    <th class="p-2 border">Stok</th>
                    <th class="p-2 border">Aktif</th>
                    <th class="p-2 border">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($products as $p)
                <tr>
                    <td class="p-2 border">
                        @if($p->image_path)
                            <img src="{{ asset('storage/'.$p->image_path) }}" alt="{{ $p->name }}" class="h-20 w-20 mx-auto rounded">
                        @else
                            <span class="text-gray-400">—</span>
                        @endif
                    </td>
                    <td class="p-2 border">{{ $p->name }}</td>
                    <td class="p-2 border">{{ $p->category->name }}</td>
                    <td class="p-2 border">Rp {{ $p->price_formatted }}</td>
                    <td class="p-2 border">{{ $p->stock }}</td>
                    <td class="p-2 border">{{ $p->is_active ? 'Ya' : 'Tidak' }}</td>
                    <td class="p-2 border space-x-2">
                        <a href="{{ route('admin.products.edit',$p) }}" class="text-blue-600 hover:underline">Edit</a>
                        <form action="{{ route('admin.products.destroy',$p) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus produk?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="7" class="p-3 text-center">Belum ada produk.</td></tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $products->links() }}</div>
    </div>
</x-app-layout>
