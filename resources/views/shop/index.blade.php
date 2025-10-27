{{-- resources/views/shop/index.blade.php --}}
@extends('layouts.app')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4">

    {{-- BAR PENCARIAN & FILTER --}}
    <form action="{{ route('shop.index') }}" method="GET" class="mb-4">
        <div class="flex items-center gap-2">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Cari produk..."
                class="w-full rounded-lg border border-slate-300 px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-300"
            />

            <select
                name="category"
                class="min-w-[170px] rounded-lg border border-slate-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-slate-300"
            >
                <option value="">Semua Kategori</option>
                @foreach($categories as $c)
                    <option value="{{ $c->id }}" {{ (string)request('category')===(string)$c->id ? 'selected' : '' }}>
                        {{ $c->name }}
                    </option>
                @endforeach
            </select>

            <button
                type="submit"
                class="min-w-[170px] rounded-lg border border-slate-300 px-3 py-2 bg-white focus:outline-none focus:ring-2 focus:ring-slate-300"
            >Filter</button>
        </div>
    </form>

    {{-- GRID PRODUK --}}
    @if($products->count())
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @foreach($products as $p)
                @php
                    $img = ($p->image_path && \Illuminate\Support\Facades\Storage::disk('public')->exists($p->image_path))
                        ? asset('storage/'.$p->image_path)
                        : 'https://placehold.co/600x450/png?text=No+Image';
                @endphp

                <a href="{{ route('shop.show', $p) }}"
                   class="group rounded-2xl border bg-white shadow-sm hover:shadow-md transition overflow-hidden">
                    {{-- gambar dibuat proporsional & tidak besar-besar --}}
                    <div class="w-full aspect-[4/3] bg-slate-50 overflow-hidden">
                        <img src="{{ $img }}"
                             alt="{{ $p->name }}"
                             loading="lazy"
                             class="w-full h-full object-cover group-hover:scale-[1.03] transition-transform duration-300">
                    </div>

                    <div class="p-3">
                        <div class="text-[11px] text-slate-500 mb-1">
                            {{ optional($p->category)->name ?? 'Lainnya' }}
                        </div>

                        <div class="text-sm font-medium text-slate-900 line-clamp-2 min-h-[2.5rem]">
                            {{ $p->name }}
                        </div>

                        <div class="mt-2 font-semibold">
                            Rp {{ number_format($p->price, 0, ',', '.') }}
                        </div>

                        <div class="mt-1 text-[12px] text-slate-500">Stok: {{ $p->stock }}</div>
                    </div>
                </a>
            @endforeach
        </div>

        {{-- PAGINASI --}}
        <div class="mt-4">
            {{ $products->onEachSide(1)->links() }}
        </div>
    @else
        <div class="text-center text-slate-500 py-10">Produk tidak ditemukan.</div>
    @endif
</div>
@endsection
