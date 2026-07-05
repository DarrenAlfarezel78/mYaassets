<?php

namespace App\Http\Controllers;

use App\Models\Borrowing;
use Illuminate\Http\Request;

class BorrowingController extends Controller
{
    public function index()
    {
        // Ganti all() menjadi paginate(10) untuk membagi data, misalnya 10 baris per halaman
        $borrowings = Borrowing::paginate(10);
        
        // Tampilkan ke halaman view
        return view('borrowings.index', compact('borrowings'));
    }

    public function create()
    {
        // Logika untuk menampilkan halaman form tambah peminjaman
        return view('borrowings.create');
    }

    public function store(Request $request)
    {
        // Nanti logika untuk menyimpan data peminjaman ditaruh di sini
    }

    public function returnAsset($id, Request $request)
    {
        // Nanti logika untuk memproses pengembalian barang ditaruh di sini
    }
}