<x-app-layout>
  <x-slot name="header">
    <div class="flex items-center justify-between">
      <h2 class="font-semibold text-xl text-slate-900">Kelola Kategori</h2>
      <a href="{{ route('admin.categories.create') }}"
         class="inline-flex items-center gap-2 px-4 py-2 rounded-lg bg-emerald-600 text-white hover:bg-emerald-700">
        <span class="text-lg leading-none">＋</span> Tambah Kategori
      </a>
    </div>
  </x-slot>

  <div class="p-6">
    <div class="bg-white border rounded-2xl shadow-sm overflow-hidden">
      <table class="w-full text-sm">
        <thead class="bg-slate-50 text-slate-600">
          <tr>
            <th class="p-3 text-left w-[60px]">No</th>
            <th class="p-3 text-left">Nama</th>
            <th class="p-3 text-left w-[180px]">Aksi</th>
          </tr>
        </thead>
        <tbody class="divide-y">
          @forelse($categories as $cat)
            @php
              $number = method_exists($categories, 'firstItem')
                ? $categories->firstItem() + $loop->index   // paginate -> urutan global
                : $loop->iteration;                          // collection biasa -> 1,2,3
            @endphp
            <tr class="hover:bg-slate-50">
              <td class="p-3 font-medium text-slate-800"> {{ $number }} </td>
              <td class="p-3 text-slate-800"> {{ $cat->name }} </td>
              <td class="p-3">
                <div class="flex gap-2">
                  <a href="{{ route('admin.categories.edit', $cat) }}"
                     class="px-3 py-1.5 rounded-md border hover:bg-slate-50">Edit</a>
                  <form action="{{ route('admin.categories.destroy', $cat) }}" method="POST"
                        onsubmit="return confirm('Hapus kategori ini?')">
                    @csrf @method('DELETE')
                    <button class="px-3 py-1.5 rounded-md border text-rose-700 hover:bg-rose-50">Hapus</button>
                  </form>
                </div>
              </td>
            </tr>
          @empty
            <tr>
              <td colspan="3" class="p-8 text-center text-slate-500">Belum ada kategori.</td>
            </tr>
          @endforelse
        </tbody>
      </table>
    </div>

    @if(method_exists($categories, 'links'))
      <div class="mt-4">
        {{ $categories->onEachSide(1)->links() }}
      </div>
    @endif
  </div>
</x-app-layout>
