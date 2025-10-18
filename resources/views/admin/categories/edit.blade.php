<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Edit Kategori</h2></x-slot>

    <div class="p-6">
        <form method="POST" action="{{ route('admin.categories.update', $category) }}">
            @csrf
            @method('PUT')
            <div class="mb-4">
                <label class="block mb-1">Nama Kategori</label>
                <input type="text" name="name" class="w-full border p-2 rounded" value="{{ old('name', $category->name) }}">
                @error('name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
            </div>
            <button class="px-4 py-2 bg-blue-600 hover:bg-blue-700 text-black rounded">Update</button>
            <a href="{{ route('admin.categories.index') }}" class="ms-2 text-gray-600">Batal</a>
        </form>
    </div>
</x-app-layout>
