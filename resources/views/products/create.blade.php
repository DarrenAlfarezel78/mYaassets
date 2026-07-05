<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Tambah Barang Baru') }}
            </h2>
            <a href="{{ route('products.index') }}" class="bg-gray-500 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded">
                Kembali
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('products.store') }}" method="POST">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <div>
                            <x-input-label for="kode_barang" :value="__('Kode Barang (Unik)')" />
                            <x-text-input id="kode_barang" name="kode_barang" type="text" class="mt-1 block w-full" :value="old('kode_barang')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('kode_barang')" />
                        </div>

                        <div>
                            <x-input-label for="nama_barang" :value="__('Nama Barang')" />
                            <x-text-input id="nama_barang" name="nama_barang" type="text" class="mt-1 block w-full" :value="old('nama_barang')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_barang')" />
                        </div>

                        <div>
                            <x-input-label for="category_id" :value="__('Kategori')" />
                            <select id="category_id" name="category_id" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                                        {{ $category->nama_kategori }}
                                    </option>
                                @endforeach
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('category_id')" />
                        </div>

                        <div>
                            <x-input-label for="stok" :value="__('Jumlah Stok')" />
                            <x-text-input id="stok" name="stok" type="number" min="0" class="mt-1 block w-full" :value="old('stok')" required />
                            <x-input-error class="mt-2" :messages="$errors->get('stok')" />
                        </div>

                        <div>
                            <x-input-label for="lokasi_penyimpanan" :value="__('Lokasi Penyimpanan')" />
                            <x-text-input id="lokasi_penyimpanan" name="lokasi_penyimpanan" type="text" class="mt-1 block w-full" :value="old('lokasi_penyimpanan')" placeholder="Misal: Lemari A, Rak 2" required />
                            <x-input-error class="mt-2" :messages="$errors->get('lokasi_penyimpanan')" />
                        </div>

                        <div>
                            <x-input-label for="kondisi_barang" :value="__('Kondisi Barang')" />
                            <select id="kondisi_barang" name="kondisi_barang" class="mt-1 block w-full border-gray-300 focus:border-indigo-500 focus:ring-indigo-500 rounded-md shadow-sm" required>
                                <option value="Baik" {{ old('kondisi_barang') == 'Baik' ? 'selected' : '' }}>Baik</option>
                                <option value="Rusak Ringan" {{ old('kondisi_barang') == 'Rusak Ringan' ? 'selected' : '' }}>Rusak Ringan</option>
                                <option value="Rusak Berat" {{ old('kondisi_barang') == 'Rusak Berat' ? 'selected' : '' }}>Rusak Berat</option>
                            </select>
                            <x-input-error class="mt-2" :messages="$errors->get('kondisi_barang')" />
                        </div>
                    </div>

                    <div class="mt-6 flex justify-end">
                        <x-primary-button>
                            {{ __('Simpan Barang') }}
                        </x-primary-button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>