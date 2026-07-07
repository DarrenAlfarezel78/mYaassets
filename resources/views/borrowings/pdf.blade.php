<!DOCTYPE html>
<html>
<head>
    <title>Laporan Peminjaman Inventaris</title>
    <style>
        body { font-family: sans-serif; font-size: 12px; }
        table { width: 100%; border-collapse: collapse; margin-top: 20px; }
        th, td { border: 1px solid #000; padding: 8px; text-align: left; }
        th { background-color: #f2f2f2; }
        .text-center { text-align: center; }
    </style>
</head>
<body>
    <h2 class="text-center">Laporan Riwayat Peminjaman Inventaris</h2>
    <p class="text-center">PT Telkomsel</p>
    <hr>
    <p>Tanggal Cetak: {{ now()->format('d M Y H:i') }}</p>
    
    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Peminjam</th>
                <th>Tanggal Pinjam</th>
                <th>Tanggal Kembali</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($borrowings as $index => $borrowing)
                <tr>
                    <td>{{ $index + 1 }}</td>
                    <td>{{ $borrowing->user->name ?? 'User Dihapus' }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrowing->tanggal_pinjam)->format('d M Y') }}</td>
                    <td>{{ \Carbon\Carbon::parse($borrowing->tanggal_kembali)->format('d M Y') }}</td>
                    <td>{{ $borrowing->status }}</td>
                </tr>
            @endforeach
        </tbody>
    </table>
</body>
</html>