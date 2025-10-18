<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Tambah Produk</h2></x-slot>

    <div class="p-6">
        <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @include('admin.products._form', ['submit' => 'Simpan'])
        </form>
    </div>
</x-app-layout>
