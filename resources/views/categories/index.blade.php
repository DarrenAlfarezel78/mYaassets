<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Master Kategori') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                    <span class="block sm:inline">{{ session('success') }}</span>
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('categories.store') }}" method="POST" class="mb-6">
                    @csrf
                    <div class="flex items-center gap-4">
                        <div class="flex-1">
                            <x-input-label for="nama_kategori" :value="__('Nama Kategori Baru')" />
                            <x-text-input id="nama_kategori" name="nama_kategori" type="text" class="mt-1 block w-full" required placeholder="Misal: Elektronik, Furniture..." />
                            <x-input-error class="mt-2" :messages="$errors->get('nama_kategori')" />
                        </div>
                        <div class="mt-6">
                            <x-primary-button>{{ __('Tambah Kategori') }}</x-primary-button>
                        </div>
                    </div>
                </form>

                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th scope="col" class="px-6 py-3">ID</th>
                                <th scope="col" class="px-6 py-3">Nama Kategori</th>
                                <th scope="col" class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($categories as $category)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4">{{ $category->id }}</td>
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $category->nama_kategori }}</td>
                                    <td class="px-6 py-4 text-center">
                                        <button class="text-blue-600 hover:underline mr-2">Edit</button>
                                        <button class="text-red-600 hover:underline">Hapus</button>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="3" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data kategori. Silakan tambahkan kategori baru.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

            </div>
        </div>
    </div>
</x-app-layout>