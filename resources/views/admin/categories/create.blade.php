<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Tambah Kategori</h2></x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.categories.store') }}">
            @csrf
            <div class="mb-4">
                <label class="block mb-1">Nama Kategori</label>
                <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name') }}">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <button class="px-4 py-2 bg-green-600 hover:bg-green-700 text-black
             rounded">Simpan</button>
            <a href="{{ route('admin.categories.index') }}" class="ms-2 text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
