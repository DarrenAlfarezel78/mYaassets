<?php

namespace App\Http\Controllers;

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
}