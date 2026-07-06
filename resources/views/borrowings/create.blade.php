<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Buat Transaksi Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-3xl mx-auto">
                
                <form action="{{ route('borrowings.store') }}" method="POST">
                    @csrf 
                    
                    <div class="mb-4">
                        <label for="user_id" class="block text-gray-700 font-bold mb-2">Nama Peminjam</label>
                        <select name="user_id" id="user_id" class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">-- Pilih User --</option>
                            @foreach($users as $user)
                                <option value="{{ $user->id }}">{{ $user->name }} ({{ $user->role?->nama_role ?? 'Tanpa Role' }})</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="grid grid-cols-2 gap-4 mb-4">
                        <div>
                            <label for="tanggal_pinjam" class="block text-gray-700 font-bold mb-2">Tanggal Pinjam</label>
                            <input type="date" name="tanggal_pinjam" id="tanggal_pinjam" class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                        <div>
                            <label for="tanggal_kembali" class="block text-gray-700 font-bold mb-2">Batas Kembali</label>
                            <input type="date" name="tanggal_kembali" id="tanggal_kembali" class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="block text-gray-700 font-bold mb-2">Pilih Barang yang Dipinjam</label>
                        <div class="bg-gray-50 p-4 border border-gray-300 rounded max-h-60 overflow-y-auto">
                            @forelse($products as $product)
                                <label class="flex items-center space-x-3 mb-3 cursor-pointer p-2 hover:bg-gray-100 rounded transition">
                                    <input type="checkbox" name="product_ids[]" value="{{ $product->id }}" class="rounded text-blue-600 shadow-sm focus:border-blue-300 focus:ring focus:ring-blue-200 focus:ring-opacity-50 w-5 h-5">
                                    <div class="flex-1">
                                        <span class="text-gray-800 font-medium">{{ $product->nama_barang }}</span>
                                        <span class="text-xs text-gray-500 block">Kode: {{ $product->kode_barang }}</span>
                                    </div>
                                    <span class="text-xs bg-blue-100 text-blue-800 px-2 py-1 rounded-full font-bold">Stok Tersedia: {{ $product->stok }}</span>
                                </label>
                            @empty
                                <p class="text-sm text-gray-500 italic">Semua barang sedang kosong atau habis dipinjam.</p>
                            @endforelse
                        </div>
                        <p class="text-xs text-gray-500 mt-1">*Bisa mencentang lebih dari satu barang.</p>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t pt-4">
                        <a href="{{ route('borrowings.index') }}" class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            Simpan Transaksi
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>