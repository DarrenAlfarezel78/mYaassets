<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-3 gap-6">
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500">Total Barang</h3>
                <p class="text-3xl font-bold">{{ $totalBarang }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500">Barang Dipinjam</h3>
                <p class="text-3xl font-bold text-yellow-600">{{ $barangDipinjam }}</p>
            </div>
            <div class="bg-white p-6 rounded-lg shadow">
                <h3 class="text-gray-500">Barang Tersedia</h3>
                <p class="text-3xl font-bold text-green-600">{{ $barangTersedia }}</p>
            </div>
        </div>
    </div>
</x-app-layout>