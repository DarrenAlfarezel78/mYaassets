<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Barang Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-2xl mx-auto">
                
                <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf 
                    
                    <div class="mb-4">
                        <label for="kode_barang" class="block text-gray-700 font-bold mb-2">Kode Barang (Unik)</label>
                        <input type="text" name="kode_barang" id="kode_barang" 
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" 
                               required placeholder="Contoh: BRG-001">
                    </div>

                    <div class="mb-4">
                        <label for="nama_barang" class="block text-gray-700 font-bold mb-2">Nama Barang</label>
                        <input type="text" name="nama_barang" id="nama_barang" 
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label class="block text-gray-700 text-sm font-bold mb-2">Gambar Barang (Opsional)</label>
                        <input type="file" name="gambar" accept="image/*" class="w-full border-gray-300 rounded-md shadow-sm">
                    </div>

                    <div class="mb-4">
                        <label for="category_id" class="block text-gray-700 font-bold mb-2">Kategori</label>
                        <select name="category_id" id="category_id" 
                                class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->nama_kategori }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="mb-4">
                        <label for="stok" class="block text-gray-700 font-bold mb-2">Jumlah Stok</label>
                        <input type="number" name="stok" id="stok" min="0"
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" 
                               required>
                    </div>

                    <div class="mb-4">
                        <label for="lokasi_penyimpanan" class="block text-gray-700 font-bold mb-2">Lokasi Penyimpanan</label>
                        <input type="text" name="lokasi_penyimpanan" id="lokasi_penyimpanan" 
                               class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" 
                               required placeholder="Contoh: Lemari A, Gudang B...">
                    </div>

                    <div class="mb-6">
                        <label for="kondisi_barang" class="block text-gray-700 font-bold mb-2">Kondisi Barang</label>
                        <select name="kondisi_barang" id="kondisi_barang" 
                                class="shadow-sm border-gray-300 rounded w-full focus:ring-blue-500 focus:border-blue-500" required>
                            <option value="Baik">Baik</option>
                            <option value="Rusak Ringan">Rusak Ringan</option>
                            <option value="Rusak Berat">Rusak Berat</option>
                        </select>
                    </div>

                    <div class="flex items-center justify-end space-x-3 border-t pt-4">
                        <a href="{{ route('products.index') }}" class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            Simpan Barang
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>