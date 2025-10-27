<x-app-layout>
  {{-- HEADER --}}
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-slate-900">Admin Dashboard</h2>
      <div class="hidden sm:flex gap-2">
        <a href="{{ route('admin.products.index') }}" class="px-3 py-2 text-sm rounded-lg border bg-white hover:bg-slate-50">Kelola Produk</a>
        <a href="{{ route('admin.categories.index') }}" class="px-3 py-2 text-sm rounded-lg border bg-white hover:bg-slate-50">Kelola Kategori</a>
        <a href="{{ route('shop.index') }}" class="px-3 py-2 text-sm rounded-lg bg-slate-900 text-white hover:bg-slate-800">Katalog</a>
      </div>
    </div>
  </x-slot>

  <div class="p-6 space-y-6">

    {{-- METRIC CARDS --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
      <div class="bg-white border rounded-2xl p-4 shadow-sm">
        <div class="text-xs text-slate-500">Total Produk</div>
        <div class="mt-1 text-2xl font-semibold">
          {{ $productCount ?? ($products instanceof \Illuminate\Pagination\LengthAwarePaginator ? $products->total() : ($products->count() ?? 0)) }}
        </div>
        <div class="mt-1 text-[11px] text-slate-500">Produk aktif di katalog</div>
      </div>

      <div class="bg-white border rounded-2xl p-4 shadow-sm">
        <div class="text-xs text-slate-500">Kategori</div>
        <div class="mt-1 text-2xl font-semibold">{{ $categoryCount ?? 0 }}</div>
        <div class="mt-1 text-[11px] text-slate-500">Kelompok produk</div>
      </div>

      <div class="bg-white border rounded-2xl p-4 shadow-sm">
        <div class="text-xs text-slate-500">Pesanan Baru</div>
        <div class="mt-1 text-2xl font-semibold">{{ $pendingOrders ?? 0 }}</div>
        <div class="mt-1 text-[11px] text-slate-500">Menunggu diproses</div>
      </div>

      <div class="bg-white border rounded-2xl p-4 shadow-sm">
        <div class="text-xs text-slate-500">Pendapatan (bulan ini)</div>
        <div class="mt-1 text-2xl font-semibold">
          Rp {{ number_format($monthlyRevenue ?? 0, 0, ',', '.') }}
        </div>
        <div class="mt-1 text-[11px] text-slate-500">{{ now()->translatedFormat('F Y') }}</div>
      </div>
    </div>

    {{-- HEADER LIST + RINGKASAN --}}
    <div class="flex items-center justify-between">
      <h3 class="font-semibold text-lg text-slate-900">Produk</h3>

      @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
        <span class="text-sm text-slate-500">
          Menampilkan {{ $products->firstItem() }}–{{ $products->lastItem() }} dari {{ $products->total() }}
        </span>
      @elseif(isset($products) && $products instanceof \Illuminate\Support\Collection)
        <span class="text-sm text-slate-500">
          Total {{ $products->count() }} produk
        </span>
      @endif
    </div>

    {{-- TABEL (DESKTOP-ONLY) --}}
    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50 text-slate-600">
            <tr>
              <th class="p-3 text-left w-20">Gambar</th>
              <th class="p-3 text-left">Nama</th>
              <th class="p-3 text-left">Kategori</th>
              <th class="p-3 text-left">Harga</th>
              <th class="p-3 text-left">Stok</th>
              <th class="p-3 text-left">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse($products as $p)
              @php
                $img = ($p->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($p->image_path))
                  ? asset('storage/'.$p->image_path)
                  : 'https://placehold.co/80x80/png?text=No+Image';
              @endphp
              <tr class="hover:bg-slate-50">
                <td class="p-3">
                  <img src="{{ $img }}" alt="{{ $p->name }}" class="h-10 w-10 rounded-lg object-cover border">
                </td>
                <td class="p-3">
                  <div class="font-medium text-slate-900 line-clamp-2">{{ $p->name }}</div>
                  <div class="text-xs text-slate-500">#{{ $p->id }}</div>
                </td>
                <td class="p-3 text-slate-700">{{ optional($p->category)->name ?? '—' }}</td>
                <td class="p-3 font-semibold">Rp {{ $p->price_formatted ?? number_format($p->price, 0, ',', '.') }}</td>
                <td class="p-3">
                  <span class="inline-flex items-center px-2 py-1 rounded-md {{ $p->stock < 5 ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                    {{ $p->stock }}
                  </span>
                </td>
                <td class="p-3">
                  <a href="{{ route('admin.products.edit', $p) }}" class="px-3 py-1.5 rounded-md border hover:bg-slate-50">Edit</a>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="6" class="p-8 text-center text-slate-500">Belum ada produk.</td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- PAGINATION --}}
    @if($products instanceof \Illuminate\Pagination\LengthAwarePaginator)
      <div class="pt-2">
        {{ $products->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</x-app-layout>
