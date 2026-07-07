<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Daftar Peminjaman') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            <div class="mb-4 flex justify-end">
                <a href="{{ route('borrowings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded shadow transition">
                    + Buat Peminjaman
                </a>
            </div>

            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg transition-colors duration-300">
                <div class="p-6 text-gray-900 dark:text-gray-100 overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-100 dark:bg-gray-700 border-b-2 border-gray-200 dark:border-gray-600
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">No</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Nama Peminjam</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Tanggal Pinjam</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Batas Kembali</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200">Daftar Barang</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200 text-center">Status</th>
                                <th class="p-3 font-semibold text-gray-700 dark:text-gray-200 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borrowings as $index => $borrowing)
                                <tr class="border-b dark:border-gray-700 hover:bg-gray-50 dark:hover:bg-gray-600 transition-colors">
                                    <td class="p-3 align-top">{{ $borrowings->firstItem() + $index }}</td>
                                    <td class="p-3 align-top font-medium">{{ $borrowing->user->name ?? 'User Terhapus' }}</td>
                                    <td class="p-3 align-top">{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                                    <td class="p-3 align-top">{{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y') }}</td>
                                    
                                    <td class="p-3 align-top">
                                        <ul class="list-disc list-inside space-y-1 text-sm text-gray-600">
                                            @foreach($borrowing->details as $detail)
                                                <li>
                                                    {{ $detail->product->nama_barang ?? 'Barang Terhapus' }} 
                                                    <span class="text-xs px-1.5 py-0.5 rounded bg-gray-100 font-mono text-gray-500">{{ $detail->status_barang }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    
                                    <td class="p-3 align-top text-center">
                                        @if($borrowing->status == 'Dipinjam')
                                            <span class="bg-yellow-100 text-yellow-800 py-1 px-2.5 rounded-full text-xs font-bold shadow-sm">{{ $borrowing->status }}</span>
                                        @elseif($borrowing->status == 'Dikembalikan')
                                            <span class="bg-green-100 text-green-800 py-1 px-2.5 rounded-full text-xs font-bold shadow-sm">{{ $borrowing->status }}</span>
                                        @else
                                            <span class="bg-red-100 text-red-800 py-1 px-2.5 rounded-full text-xs font-bold shadow-sm">{{ $borrowing->status }}</span>
                                        @endif
                                    </td>
                                    
                                    <td class="p-3 align-top text-center space-x-2">
                                        @if($borrowing->status == 'Dipinjam' || $borrowing->status == 'Terlambat')
                                            <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" class="inline-block">
                                                @csrf
                                                @method('PUT')
                                                <button type="submit" class="text-sm bg-green-600 hover:bg-green-700 text-white font-semibold py-1 px-3 rounded shadow-sm transition" onclick="return confirm('Proses pengembalian untuk seluruh barang dalam transaksi ini?')">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-xs text-gray-400 italic">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="7" class="p-4 text-center text-gray-500 font-medium">
                                        Belum ada riwayat transaksi peminjaman.
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