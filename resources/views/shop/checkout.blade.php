<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl">Checkout</h2>
    </x-slot>

    <div class="py-6">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">

            <div class="mb-4"> 
                @if (session('success'))
                    <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                        <span class="block sm:inline">{{ session('success') }}</span>
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                        <strong class="font-bold">Oops! Ada masalah:</strong>
                        <ul class="mt-2 list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </div>

            <form method="POST" action="{{ route('checkout.store') }}" class="space-y-3 bg-white border rounded p-4 shadow-sm">
                @csrf
                <div>
                    <label class="block text-sm font-medium text-gray-700">Nama Penerima</label>
                    <input name="recipient_name" value="{{ old('recipient_name') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2">
                    @error('recipient_name') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Telepon</label>
                    <input name="phone" value="{{ old('phone') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2">
                    @error('phone') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Alamat</label>
                    <textarea name="address_text" rows="3" class="w-full border-gray-300 rounded-md shadow-sm p-2">{{ old('address_text') }}</textarea>
                    @error('address_text') <p class="text-red-600 text-sm mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700">Catatan (opsional)</label>
                    <input name="note" value="{{ old('note') }}" class="w-full border-gray-300 rounded-md shadow-sm p-2">
                </div>
                <button type="submit" class="px-4 py-2 bg-emerald-600 text-white rounded-md font-semibold hover:bg-emerald-700">
                    Buat Pesanan
                </button>
            </form>
            
        </div>
    </div>
</x-app-layout>