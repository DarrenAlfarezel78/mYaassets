<?php

namespace App\Http\Controllers;

use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Borrowing;
use App\Models\BorrowingDetail;
use App\Models\Product;
use App\Models\User;

class BorrowingController extends Controller
{
    public function index()
    {
        $borrowings = Borrowing::with(['user', 'details.product'])->latest()->paginate(10);
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        $users = User::all();
        $products = Product::where('stok', '>', 0)->get();

        return view('borrowings.create', compact('users', 'products'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tanggal_pinjam' => 'required|date',
            'tanggal_kembali' => 'required|date|after_or_equal:tanggal_pinjam', 
            'product_ids' => 'required|array|min:1', 
            'product_ids.*' => 'exists:products,id',
        ]);

        DB::transaction(function () use ($request) {
            $borrowing = Borrowing::create([
                'user_id' => $request->user_id,
                'tanggal_pinjam' => $request->tanggal_pinjam,
                'tanggal_kembali' => $request->tanggal_kembali,
                'status' => 'Dipinjam',
            ]);

            foreach ($request->product_ids as $product_id) {
                BorrowingDetail::create([
                    'borrowing_id' => $borrowing->id,
                    'product_id' => $product_id,
                    'status_barang' => 'Bagus',
                ]);

                $product = Product::find($product_id);
                $product->decrement('stok', 1);
            }
        });

        return redirect()->route('borrowings.index');
    }
    
    public function returnAsset($id)
    {
        // Gunakan DB Transaction agar stok dan status aman
        DB::transaction(function () use ($id) {
            $borrowing = Borrowing::with('details')->findOrFail($id);
            
            // Ubah status transaksi menjadi Dikembalikan
            $borrowing->update(['status' => 'Dikembalikan']);

            // Kembalikan stok setiap barang yang dipinjam (+1)
            foreach ($borrowing->details as $detail) {
                $product = Product::find($detail->product_id);
                if ($product) {
                    $product->increment('stok', 1);
                }
            }
        });

        return redirect()->route('borrowings.index');
    }

    public function dashboard()
    {
        $totalBarang = \App\Models\Product::count();
        $barangDipinjam = \App\Models\Borrowing::where('status', 'Dipinjam')->count();
        $barangTersedia = \App\Models\Product::sum('stok');

        // Mengambil data peminjaman per bulan untuk tahun ini
        $peminjamanPerBulan = \App\Models\Borrowing::selectRaw('MONTH(tanggal_pinjam) as bulan, COUNT(*) as total')
            ->whereYear('tanggal_pinjam', date('Y'))
            ->groupBy('bulan')
            ->pluck('total', 'bulan')
            ->toArray();

        // Menyusun array untuk 12 bulan (Januari - Desember)
        $dataGrafik = [];
        for ($i = 1; $i <= 12; $i++) {
            $dataGrafik[] = $peminjamanPerBulan[$i] ?? 0;
        }

        return view('dashboard', compact('totalBarang', 'barangDipinjam', 'barangTersedia', 'dataGrafik'));
    }

    // Method untuk menampilkan daftar riwayat (yang sudah dikembalikan/terlambat)
    public function history()
    {
        $borrowings = \App\Models\Borrowing::with(['user'])
            ->whereIn('status', ['Dikembalikan', 'Terlambat'])
            ->orderBy('updated_at', 'desc')
            ->paginate(10);

        return view('borrowings.history', compact('borrowings'));
    }

    // Method untuk memproses pengembalian barang
    public function returnItem(\App\Models\Borrowing $borrowing)
    {
        // Ubah status peminjaman utama
        $borrowing->update([
            'status' => 'Dikembalikan',
            'tanggal_kembali' => now(), // Mencatat tanggal dikembalikan secara riil
        ]);

        // Mengembalikan stok barang berdasarkan detail peminjaman
        $borrowingDetails = \App\Models\BorrowingDetail::where('borrowing_id', $borrowing->id)->get();
        foreach ($borrowingDetails as $detail) {
            $product = \App\Models\Product::find($detail->product_id);
            if ($product) {
                $product->increment('stok'); // Stok otomatis bertambah kembali
            }
        }

        return redirect()->back()->with('success', 'Barang berhasil dikembalikan dan stok telah diperbarui.');
    }

    public function exportPdf()
    {
        // Ambil data riwayat yang sudah dikembalikan/terlambat
        $borrowings = \App\Models\Borrowing::with(['user'])
            ->whereIn('status', ['Dikembalikan', 'Terlambat'])
            ->orderBy('updated_at', 'desc')
            ->get();

        // Render ke tampilan PDF
        $pdf = Pdf::loadView('borrowings.pdf', compact('borrowings'));
        
        // Download file dengan nama laporan-inventaris.pdf
        return $pdf->download('laporan-inventaris-telkomsel.pdf');
    }
}