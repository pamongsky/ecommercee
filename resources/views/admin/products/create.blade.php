<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-slate-900">Tambah Produk</h2>
      <a href="{{ route('admin.products.index') }}" class="text-slate-600 hover:underline">← Kembali</a>
    </div>
  </x-slot>

  <div class="p-6">
    <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data"
          class="bg-white border rounded-2xl shadow-sm p-6">
      @csrf

      <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
        {{-- Nama --}}
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700">Nama Produk</label>
          <input type="text" name="name" value="{{ old('name') }}"
                 class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-900 focus:ring-slate-900"
                 placeholder="cth: Keyboard Mechanical RGB">
          @error('name') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Kategori --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Kategori</label>
          <select name="category_id"
                  class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-900 focus:ring-slate-900">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $c)
              <option value="{{ $c->id }}" @selected(old('category_id') == $c->id)>{{ $c->name }}</option>
            @endforeach
          </select>
          @error('category_id') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Harga (Rp) --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Harga (Rp)</label>
          <input id="priceMask" type="text" inputmode="numeric" value="{{ old('price') }}"
                 class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-900 focus:ring-slate-900"
                 placeholder="cth: 150000">
          <input id="priceReal" name="price" type="hidden" value="{{ old('price') }}">
          @error('price') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Stok --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Stok</label>
          <input type="number" name="stock" min="0" value="{{ old('stock', 0) }}"
                 class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-900 focus:ring-slate-900">
          @error('stock') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Aktif --}}
        <div>
          <label class="block text-sm font-medium text-slate-700">Aktif?</label>
          <select name="is_active"
                  class="mt-1 w-full rounded-lg border-slate-300 focus:border-slate-900 focus:ring-slate-900">
            <option value="1" @selected(old('is_active',1)==1)>Ya</option>
            <option value="0" @selected(old('is_active',1)==0)>Tidak</option>
          </select>
          @error('is_active') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>

        {{-- Gambar --}}
        <div class="md:col-span-2">
          <label class="block text-sm font-medium text-slate-700">Gambar (opsional)</label>
          <div class="mt-1 flex items-start gap-4">
            <input type="file" name="image" accept="image/*"
                   class="rounded-lg border-slate-300 focus:border-slate-900 focus:ring-slate-900"
                   onchange="previewImage(this)">
            <img id="imgPreview" class="h-20 w-20 rounded-lg object-cover border hidden" alt="preview">
          </div>
          <p class="mt-1 text-xs text-slate-500">Format: JPG/PNG, disarankan rasio 1:1, ukuran &lt; 1 MB.</p>
          @error('image') <p class="mt-1 text-xs text-rose-600">{{ $message }}</p> @enderror
        </div>
      </div>

      <div class="mt-6 flex items-center gap-3">
        <button class="inline-flex items-center gap-2 px-5 py-2.5 rounded-lg
                 bg-emerald-600 text-white hover:bg-emerald-700">Simpan</button>
        <a href="{{ route('admin.products.index') }}" class="px-5 py-2.5 rounded-lg border hover:bg-slate-50">Batal</a>
      </div>
    </form>
  </div>

  <script>
    // ---- preview image
    function previewImage(input){
      const file = input.files?.[0];
      const img  = document.getElementById('imgPreview');
      if(!file){ img.classList.add('hidden'); img.src=''; return; }
      const reader = new FileReader();
      reader.onload = e => { img.src = e.target.result; img.classList.remove('hidden'); };
      reader.readAsDataURL(file);
    }

    // ---- price masking (tampilan ribuan, kirim angka asli)
    const mask = document.getElementById('priceMask');
    const real = document.getElementById('priceReal');

    const format = (n) => n.replace(/\D/g,'').replace(/^0+(?=\d)/,'').replace(/\B(?=(\d{3})+(?!\d))/g,'.');

    function syncFromMask() {
      const raw = mask.value.replace(/\D/g,'');
      real.value = raw.length ? raw : 0;
      mask.value = format(mask.value);
    }

    mask.addEventListener('input', syncFromMask);
    mask.addEventListener('blur', syncFromMask);

    // inisialisasi ulang saat halaman pertama kali load (agar old('price') kepasang)
    syncFromMask();
  </script>
</x-app-layout>
