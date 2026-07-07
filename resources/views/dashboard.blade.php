<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">Dashboard</h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if($stokMenipis->count() > 0)
                <div class="bg-red-100 border-l-4 border-red-500 text-red-700 p-4 mb-6 rounded shadow" role="alert">
                    <p class="font-bold">Perhatian! Terdapat {{ $stokMenipis->count() }} barang dengan stok menipis:</p>
                    <ul class="mt-2 list-disc list-inside text-sm">
                        @foreach($stokMenipis as $item)
                            <li><strong>{{ $item->nama_barang }}</strong> (Kode: {{ $item->kode_barang }}) - Tersisa: <span class="font-bold text-red-900">{{ $item->stok }} unit</span></li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-6">
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow transition-colors duration-300">
                    <h3 class="text-gray-500 dark:text-gray-400">Total Barang</h3>
                    <p class="text-3xl font-bold text-gray-900 dark:text-white">{{ $totalBarang }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow transition-colors duration-300">
                    <h3 class="text-gray-500 dark:text-gray-400">Barang Dipinjam</h3>
                    <p class="text-3xl font-bold text-yellow-600 dark:text-yellow-400">{{ $barangDipinjam }}</p>
                </div>
                <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow transition-colors duration-300">
                    <h3 class="text-gray-500 dark:text-gray-400">Barang Tersedia</h3>
                    <p class="text-3xl font-bold text-green-600 dark:text-green-400">{{ $barangTersedia }}</p>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 p-6 rounded-lg shadow transition-colors duration-300">
                <h3 class="text-lg font-bold text-gray-700 dark:text-gray-200 mb-4">Grafik Peminjaman Tahun {{ date('Y') }}</h3>
                <div class="relative h-72 w-full">
                    <canvas id="grafikPeminjaman"></canvas>
                </div>
            </div>

        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const ctx = document.getElementById('grafikPeminjaman').getContext('2d');
            const dataGrafik = @json($dataGrafik);
            
            new Chart(ctx, {
                type: 'bar',
                data: {
                    labels: ['Jan', 'Feb', 'Mar', 'Apr', 'Mei', 'Jun', 'Jul', 'Ags', 'Sep', 'Okt', 'Nov', 'Des'],
                    datasets: [{
                        label: 'Total Peminjaman',
                        data: dataGrafik,
                        backgroundColor: 'rgba(59, 130, 246, 0.5)',
                        borderColor: 'rgb(59, 130, 246)',
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    scales: {
                        y: {
                            beginAtZero: true,
                            ticks: { stepSize: 1 }
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>