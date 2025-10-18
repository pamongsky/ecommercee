<x-app-layout>
    <x-slot name="header"><h2 class="font-semibold text-xl">Edit Produk</h2></x-slot>

    <div class="p-6">
        <form action="{{ route('admin.products.update', $product) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            @include('admin.products._form', ['submit' => 'Update'])
        </form>
    </div>
</x-app-layout>
