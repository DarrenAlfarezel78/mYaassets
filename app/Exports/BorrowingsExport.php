<?php

namespace App\Exports;

use App\Models\Borrowing;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class BorrowingsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        // Hanya mengambil data riwayat yang sudah selesai (Dikembalikan/Terlambat)
        return Borrowing::with('user')
            ->whereIn('status', ['Dikembalikan', 'Terlambat'])
            ->orderBy('updated_at', 'desc')
            ->get();
    }

    public function map($borrowing): array
    {
        return [
            $borrowing->id,
            $borrowing->user->name ?? 'User Dihapus',
            \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y'),
            \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y'),
            $borrowing->status,
        ];
    }

    public function headings(): array
    {
        return [
            'ID Transaksi',
            'Nama Peminjam',
            'Tanggal Pinjam',
            'Tanggal Kembali',
            'Status'
        ];
    }
}