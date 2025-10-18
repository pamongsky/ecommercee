<x-app-layout>

    <x-slot name="header">

        <h2 class="font-semibold text-xl">

            <a href="{{ route('admin.dashboard') }}" class="text-blue-600 hover:underline">

                Admin Dashboard

            </a>

        </h2>

    </x-slot>



    <div class="p-6 space-y-4">

        <p>Selamat datang, {{ auth()->user()->name }} (Admin)</p>



        <div class="space-x-4">

            <a href="{{ route('admin.products.index') }}"

               class="px-4 py-2 bg-blue-600 text-black rounded">

               Kelola Produk

            </a>



             <a href="{{ route('shop.index') }}"

   class="px-4 py-2 bg-gray-600 text-black rounded hover:bg-gray-700">

  Dashboard Utama

</a>





           

            <a href="{{ route('admin.categories.index') }}"

   class="px-4 py-2 bg-green-600 text-black rounded hover:bg-green-700">

   Kelola Kategori

</a>



<h3 class="font-semibold text-lg mt-6 mb-2">Produk Terbaru</h3>

<table class="w-full border text-sm">

    <thead class="bg-gray-50">

        <tr>

            <th class="p-2 border">Gambar</th>

            <th class="p-2 border">Nama</th>

            <th class="p-2 border">Kategori</th>

            <th class="p-2 border">Harga</th>

            <th class="p-2 border">Stok</th>

            <th class="p-2 border">Aksi</th>

        </tr>

    </thead>

    <tbody>

    @forelse($products as $p)

        <tr>

            <td class="p-2 border text-center">

                @if($p->image_path)

                    <img src="{{ asset('storage/'.$p->image_path) }}"

                         class="h-20 w-20 object-cover mx-auto rounded" alt="{{ $p->name }}">

                @else

                    <span class="text-gray-400">—</span>

                @endif

            </td>

            <td class="p-2 border">{{ $p->name }}</td>

            <td class="p-2 border">{{ $p->category->name }}</td>

            <td class="p-2 border">Rp {{ $p->price_formatted }}</td>

            <td class="p-2 border">{{ $p->stock }}</td>

            <td class="p-2 border">

                <a href="{{ route('admin.products.edit', $p) }}" class="text-blue-600 hover:underline">Edit</a>

            </td>

        </tr>

    @empty

        <tr><td colspan="6" class="p-3 text-center">Belum ada produk.</td></tr>

    @endforelse

    </tbody>

</table>





        </div>

    </div>

</x-app-layout>