<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Kategori Baru') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 max-w-xl mx-auto">
                
                <form action="{{ route('categories.store') }}" method="POST">
                    @csrf 
                    
                    <div class="mb-4">
                        <label for="nama_kategori" class="block text-gray-700 font-bold mb-2">Nama Kategori</label>
                        <input type="text" name="nama_kategori" id="nama_kategori" 
                               class="shadow-sm border-gray-300 rounded w-full py-2 px-3 text-gray-700 focus:outline-none focus:ring-blue-500 focus:border-blue-500" 
                               required placeholder="Contoh: Laptop, Monitor, dll...">
                    </div>

                    <div class="flex items-center justify-end mt-6 space-x-3">
                        <a href="{{ route('categories.index') }}" class="text-gray-500 hover:text-gray-700 font-medium py-2 px-4 rounded transition">
                            Batal
                        </a>
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                            Simpan Kategori
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</x-app-layout>