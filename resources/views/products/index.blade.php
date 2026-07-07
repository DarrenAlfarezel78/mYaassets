<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Kelola Barang') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4 flex flex-col sm:flex-row justify-between items-center gap-4">
                <form method="GET" action="{{ route('products.index') }}" class="flex w-full sm:w-1/3">
                    <input type="text" name="search" value="{{ $search ?? '' }}" placeholder="Cari nama atau kode barang..." 
                           class="w-full border-gray-300 rounded-l-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                    <button type="submit" class="bg-gray-800 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-r-md transition">
                        Cari
                    </button>
                </form>

                <a href="{{ route('products.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition whitespace-nowrap">
                    + Tambah Barang
                </a>
            </div>

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-100 border-b-2 border-gray-200">
                                <th class="p-3 font-semibold text-gray-700">No</th>
                                <th class="p-3 font-semibold text-gray-700">Kode</th>
                                <th class="p-3 font-semibold text-gray-700">Nama Barang</th>
                                <th class="p-3 font-semibold text-gray-700">Kategori</th>
                                <th class="p-3 font-semibold text-gray-700">Stok</th>
                                <th class="p-3 font-semibold text-gray-700">Kondisi</th>
                                <th class="p-3 font-semibold text-gray-700 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($products as $index => $product)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="p-3">{{ $products->firstItem() + $index }}</td>
                                    <td class="p-3"><span class="bg-gray-200 text-gray-800 py-1 px-2 rounded text-sm font-mono">{{ $product->kode_barang }}</span></td>
                                    <td class="p-3 font-medium">{{ $product->nama_barang }}</td>
                                    <td class="p-3">{{ $product->category->nama_kategori ?? 'Tanpa Kategori' }}</td>
                                    <td class="p-3">{{ $product->stok }}</td>
                                    <td class="p-3">
                                        @if($product->kondisi_barang == 'Baik')
                                            <span class="bg-green-100 text-green-800 py-1 px-2 rounded-full text-xs font-bold">{{ $product->kondisi_barang }}</span>
                                        @elseif($product->kondisi_barang == 'Rusak Ringan')
                                            <span class="bg-yellow-100 text-yellow-800 py-1 px-2 rounded-full text-xs font-bold">{{ $product->kondisi_barang }}</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 py-1 px-2 rounded-full text-xs font-bold">{{ $product->kondisi_barang }}</span>
                                        @endif
                                    </td>
                                    <td class="p-3 text-center space-x-2">
                                        <a href="{{ route('products.edit', $product->id) }}" class="text-yellow-600 hover:text-yellow-800 font-medium">Edit</a>
                                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="inline-block">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-red-600 hover:text-red-800 font-medium" onclick="return confirm('Yakin ingin menghapus barang ini?')">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500 font-medium">
                                        Belum ada data barang. Silakan tambah data baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    
                    <div class="mt-4">
                        {{ $products->links() }}
                    </div>
                </div>
            </div>

        </div>
    </div>
</x-app-layout>