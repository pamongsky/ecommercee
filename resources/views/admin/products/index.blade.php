<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <div>
        <h2 class="font-semibold text-xl text-slate-900">Kelola Produk</h2>
        
      </div>

      <div class="flex items-center gap-2">
        <a href="{{ route('admin.products.create') }}"
           class="px-3 py-2 text-sm rounded-lg bg-blue-600 text-white hover:bg-blue-700">
          + Tambah
        </a>
      </div>
    </div>
  </x-slot>

  <div class="p-6 space-y-4">

    {{-- toolbar kecil (info & optional search) --}}
    <div class="flex items-center justify-between">
      <div class="text-sm text-slate-500">
        @php
          $total = $products instanceof \Illuminate\Contracts\Pagination\Paginator ? $products->total() : $products->count();
        @endphp
        Total <span class="font-medium text-slate-700">{{ $total }}</span> produk
      </div>

      {{-- jika mau aktifkan pencarian, tinggal aktifkan form berikut dan handle di controller --}}
      {{-- 
      <form method="GET" class="hidden md:block">
        <input name="q" value="{{ request('q') }}" placeholder="Cari nama/kategori…"
               class="w-64 rounded-lg border px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-slate-200">
      </form>
      --}}
    </div>

    {{-- tabel --}}
    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
      <div class="overflow-x-auto">
        <table class="w-full text-sm">
          <thead class="bg-slate-50/80 text-slate-600 sticky top-0">
            <tr>
              <th class="p-3 text-left w-24">Gambar</th>
              <th class="p-3 text-left">Nama</th>
              <th class="p-3 text-left">Kategori</th>
              <th class="p-3 text-left">Harga</th>
              <th class="p-3 text-left">Stok</th>
              <th class="p-3 text-left">Aktif</th>
              <th class="p-3 text-left w-40">Aksi</th>
            </tr>
          </thead>
          <tbody class="divide-y">
            @forelse ($products as $p)
              @php
                $img = ($p->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($p->image_path))
                  ? asset('storage/'.$p->image_path)
                  : 'https://placehold.co/160x160/png?text=No+Image';
              @endphp
              <tr class="hover:bg-slate-50">
                <td class="p-3">
                  <img src="{{ $img }}" alt="{{ $p->name }}"
                       class="h-14 w-14 rounded-lg object-cover border">
                </td>

                <td class="p-3">
                  <div class="font-medium text-slate-900 leading-5">{{ $p->name }}</div>
                  <div class="text-[11px] text-slate-500 mt-0.5">#{{ $p->id }}</div>
                </td>

                <td class="p-3 text-slate-700">
                  {{ optional($p->category)->name ?? '—' }}
                </td>

                <td class="p-3 font-semibold">
                  Rp {{ $p->price_formatted ?? number_format($p->price,0,',','.') }}
                </td>

                <td class="p-3">
                  <span class="inline-flex items-center px-2 py-1 rounded-md
                               {{ $p->stock < 5 ? 'bg-rose-50 text-rose-700' : 'bg-emerald-50 text-emerald-700' }}">
                    {{ $p->stock }}
                  </span>
                </td>

                <td class="p-3">
                  @php $active = isset($p->is_active) ? $p->is_active : 'Ya'; @endphp
                  <span class="inline-flex items-center px-2 py-1 rounded-md
                               {{ ($active === 'Ya' || $active == 1) ? 'bg-blue-50 text-blue-700' : 'bg-slate-100 text-slate-600' }}">
                    {{ ($active === 'Ya' || $active == 1) ? 'Ya' : 'Tidak' }}
                  </span>
                </td>

                <td class="p-3">
                  <div class="flex items-center gap-2">
                    <a href="{{ route('admin.products.edit', $p) }}"
                       class="px-3 py-1.5 rounded-lg border hover:bg-slate-50">Edit</a>

                    <form action="{{ route('admin.products.destroy', $p) }}" method="POST"
                          onsubmit="return confirm('Hapus produk ini?')">
                      @csrf @method('DELETE')
                      <button type="submit"
                              class="px-3 py-1.5 rounded-lg border text-rose-600 hover:bg-rose-50">
                        Hapus
                      </button>
                    </form>
                  </div>
                </td>
              </tr>
            @empty
              <tr>
                <td colspan="7" class="p-8 text-center text-slate-500">
                  Belum ada produk.
                </td>
              </tr>
            @endforelse
          </tbody>
        </table>
      </div>
    </div>

    {{-- pagination (kalau pakai paginate) --}}
    @if($products instanceof \Illuminate\Contracts\Pagination\Paginator)
      <div class="pt-2">
        {{ $products->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</x-app-layout>
