@csrf
<div class="space-y-4">
    {{-- Nama --}}
    <div>
        <label class="block mb-1">Nama Produk</label>
        <input type="text" name="name" class="w-full border p-2 rounded"
               value="{{ old('name', $product->name ?? '') }}">
        @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Kategori --}}
    <div>
        <label class="block mb-1">Kategori</label>
        <select name="category_id" class="w-full border p-2 rounded">
            <option value="">-- Pilih Kategori --</option>
            @foreach($categories as $c)
                <option value="{{ $c->id }}"
                        @selected(old('category_id', $product->category_id ?? '') == $c->id)>
                    {{ $c->name }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Harga --}}
    <div>
        <label class="block mb-1">Harga (Rp)</label>
        <input type="number" name="price" min="0" class="w-full border p-2 rounded"
               value="{{ old('price', $product->price ?? 0) }}">
        @error('price') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Stok --}}
    <div>
        <label class="block mb-1">Stok</label>
        <input type="number" name="stock" min="0" class="w-full border p-2 rounded"
               value="{{ old('stock', $product->stock ?? 0) }}">
        @error('stock') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Aktif --}}
    <div>
        <label class="block mb-1">Aktif?</label>
        <select name="is_active" class="w-full border p-2 rounded">
            <option value="1" @selected(old('is_active', $product->is_active ?? 1)==1)>Ya</option>
            <option value="0" @selected(old('is_active', $product->is_active ?? 1)==0)>Tidak</option>
        </select>
        @error('is_active') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
    </div>

    {{-- Gambar (opsional) --}}
    <div>
        <label class="block mb-1">Gambar (opsional)</label>
        <input type="file" name="image" accept="image/*" class="w-full border p-2 rounded">
        @error('image') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror

        @isset($product->image_path)
            <img src="{{ asset('storage/'.$product->image_path) }}" alt="" class="mt-2 h-20">
        @endisset
    </div>
</div>

<div class="mt-6">
    <button class="px-4 py-2 bg-red-600 text-white
     rounded">{{ $submit ?? 'Simpan' }}</button>
    <a href="{{ route('admin.products.index') }}" class="ms-2 text-gray-600">Batal</a>
</div>
