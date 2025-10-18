<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Kategori</h2>
    </x-slot>

    <div class="p-6">
        <a href="{{ route('admin.categories.create') }}" class="px-3 py-2 bg-blue-600 text-black rounded">
            + Tambah Kategori
        </a>

        @if(session('success'))
            <div class="mt-3 p-3 bg-green-100 text-green-800 rounded">
                {{ session('success') }}
            </div>
        @endif

        <table class="w-full mt-4 border text-sm">
            <thead class="bg-gray-50">
                <tr>
                    <th class="p-2 border">Nama</th>
                    <th class="p-2 border w-32">Aksi</th>
                </tr>
            </thead>
            <tbody>
            @forelse($categories as $c)
                <tr>
                    <td class="p-2 border">{{ $c->name }}</td>
                    <td class="p-2 border">
                        <a href="{{ route('admin.categories.edit', $c) }}" class="text-blue-600">Edit</a>
                        <form action="{{ route('admin.categories.destroy', $c) }}" method="POST" class="inline"
                              onsubmit="return confirm('Hapus kategori ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 ms-2">Hapus</button>
                        </form>
                    </td>
                </tr>
            @empty
                <tr><td colspan="2" class="p-3 text-center border">Belum ada kategori.</td></tr>
            @endforelse
            </tbody>
        </table>

        <div class="mt-4">{{ $categories->links() }}</div>
    </div>
</x-app-layout>
