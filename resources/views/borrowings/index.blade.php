<x-app-layout>
    <x-slot name="header">
        <div class="flex justify-between items-center">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Data Peminjaman') }}
            </h2>
            <a href="{{ route('borrowings.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded">
                + Pinjam Barang
            </a>
        </div>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
            @if (session('success'))
                <div class="mb-4 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                    {{ session('success') }}
                </div>
            @endif

            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <div class="relative overflow-x-auto border sm:rounded-lg">
                    <table class="w-full text-sm text-left text-gray-500">
                        <thead class="text-xs text-gray-700 uppercase bg-gray-50 border-b">
                            <tr>
                                <th class="px-6 py-3">Peminjam</th>
                                <th class="px-6 py-3">Barang</th>
                                <th class="px-6 py-3">Tgl Pinjam</th>
                                <th class="px-6 py-3">Tgl Kembali</th>
                                <th class="px-6 py-3">Status</th>
                                <th class="px-6 py-3 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @forelse ($borrowings as $borrowing)
                                <tr class="bg-white border-b hover:bg-gray-50">
                                    <td class="px-6 py-4 font-medium text-gray-900">{{ $borrowing->user->name ?? '-' }}</td>
                                    <td class="px-6 py-4">
                                        @foreach($borrowing->details as $detail)
                                            {{ $detail->product->nama_barang ?? '-' }}
                                        @endforeach
                                    </td>
                                    <td class="px-6 py-4">{{ $borrowing->tanggal_pinjam }}</td>
                                    <td class="px-6 py-4">{{ $borrowing->tanggal_kembali }}</td>
                                    <td class="px-6 py-4">
                                        @if($borrowing->status == 'Dipinjam')
                                            <span class="bg-yellow-100 text-yellow-800 text-xs font-medium px-2.5 py-0.5 rounded border border-yellow-300">Dipinjam</span>
                                        @else
                                            <span class="bg-green-100 text-green-800 text-xs font-medium px-2.5 py-0.5 rounded border border-green-300">Dikembalikan</span>
                                        @endif
                                    </td>
                                    <td class="px-6 py-4 text-center">
                                        @if($borrowing->status == 'Dipinjam')
                                            <form action="{{ route('borrowings.return', $borrowing->id) }}" method="POST" onsubmit="return confirm('Proses pengembalian akan menambah stok barang kembali. Lanjutkan?');">
                                                @csrf
                                                <button type="submit" class="bg-indigo-500 hover:bg-indigo-700 text-white text-xs font-bold py-1 px-3 rounded">
                                                    Kembalikan
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400 italic">Selesai</span>
                                        @endif
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-6 py-4 text-center text-gray-500">
                                        Belum ada data transaksi peminjaman.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>

                <div class="mt-4">
                    {{ $borrowings->links() }}
                </div>

            </div>
        </div>
    </div>
</x-app-layout>