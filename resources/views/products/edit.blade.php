<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Data Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto">
                
                <form action="{{ route('products.update', $product->id) }}" method="POST">
                    @csrf 
                    @method('PUT') <div class="mb-4">
                        <label for="kode_barang" class="block text-gray-700 font-bold mb-2">Kode Barang (Unik)</label>
                        <input type="text" name="kode_barang" id="kode_barang" value="{{ $product->kode_barang }}"
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="nama_barang" class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" value="{{ $product->nama_barang }}"
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori</label>
                        <select name="category_id" id="category_id" 
                                class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" {{ $product->category_id == $category->id ? 'selected' : '' }}>
                                    {{ $category->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="stok" class="block text-gray-700 font-bold mb-2">Jumlah Stok</label>
                        <input type="number" name="stok" id="stok" value="{{ $product->stok }}" min="0"
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-4">
                        <label for="lokasi_penyimpanan" class="block text-gray-700 font-bold mb-2">Lokasi Penyimpanan</label>
                        <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" value="{{ $product->lokasi_penyimpanan }}"
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                    </div>

                    <div class="mb-6">
                        <label for="kondisi_barang" class="block text-gray-700 font-bold mb-2">Kondisi Barang</label>
                        <select name="kondisi_barang" id="kondisi_barang" 
                                class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="Baik" {{ $product->kondisi_barang == 'Baik' ? 'selected' : '' }}>Baik</option>
                            <option value="Rusak Ringan" {{ $product->kondisi_barang == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                            <option value="Rusak Berat" {{ $product->kondisi_barang == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t pt-4">
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-yellow-500 hover:bg-yellow-600 text-white font-bold py-2 px-4 rounded shadow transition">
                            Simpan Perubahan
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>