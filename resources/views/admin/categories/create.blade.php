<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-slate-900">Tambah Kategori</h2>
      <a href="{{ route('admin.categories.index') }}" class="text-sm text-slate-600 hover:underline">← Kembali</a>
    </div>
  </x-slot>

  <div class="p-6">
    <form action="{{ route('admin.categories.store') }}" method="POST"
          class="bg-white border rounded-2xl shadow-sm p-4 max-w-3xl">
      @csrf

      <label class="block text-sm font-medium text-slate-700">Nama Kategori</label>
      <input type="text" name="name" value="{{ old('name') }}" required
             class="mt-1 w-full rounded-lg border px-3 py-2 focus:outline-none focus:ring-2 focus:ring-slate-200">

      @error('name')
        <p class="text-sm text-rose-600 mt-1">{{ $message }}</p>
      @enderror

      <div class="mt-4 flex items-center gap-2">
        <button class="px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">Simpan</button>
        <a href="{{ route('admin.categories.index') }}" class="px-4 py-2 rounded-lg border hover:bg-slate-50">Batal</a>
      </div>
    </form>
  </div>
</x-app-layout>
