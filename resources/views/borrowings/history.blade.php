<x-app-layout>
    <x-slot name="header">
        <div class="flex flex-col sm:flex-row justify-between items-center gap-4">
            <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
                {{ __('Riwayat Peminjaman') }}
            </h2>
            <div class="flex space-x-3">
                <a href="{{ route('borrowings.excel') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-2 px-4 rounded shadow transition">
                    Export Excel
                </a>
                <a href="{{ route('borrowings.pdf') }}" class="bg-red-600 hover:bg-red-700 text-white font-bold py-2 px-4 rounded shadow transition">
                    Cetak Laporan (PDF)
                </a>
            </div>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="w-full text-left border-collapse whitespace-nowrap">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600">
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">No</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Nama Peminjam</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Tanggal Pinjam</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Tanggal Kembali</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Status</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borrowings as $index => $borrowing)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <td class="p-3">{{ $borrowings->firstItem() + $index }}</td>
                                    <td class="p-3 font-medium">{{ $borrowing->user->name ?? 'User Dihapus' }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                                    <td class="p-3">{{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y') }}</td>
                                    <td class="p-3">
                                        <span class="bg-blue-100 text-blue-800 dark:bg-blue-900 dark:text-blue-200 py-1 px-2 rounded-full text-xs font-bold">
                                            {{ $borrowing->status }}
                                        </span>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="p-4 text-center text-gray-500 dark:text-gray-400 font-medium">
                                        Belum ada riwayat pengembalian barang.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="mt-4">
                        {{ $borrowings->links() }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>