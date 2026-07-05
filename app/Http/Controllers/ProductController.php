<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $products = \App\Models\Product::all();
        // Fitur Pencarian & Pagination (Wajib di Challenge)
        $query = Product::with('category');

        if ($request->has('search')) {
            $query->where('nama_barang', 'like', '%' . $request->search . '%')
                  ->orWhere('kode_barang', 'like', '%' . $request->search . '%');
        }

        // Tampilkan 10 data per halaman
        $products = $query->latest()->paginate(10);

        return view('products.index', compact('products'));
    }

    public function create()
    {
        // Ambil data kategori untuk ditampilkan di pilihan (dropdown) form tambah barang
        $categories = Category::all();
        return view('products.create', compact('categories'));
    }

    public function store(Request $request)
    {
        // 1. Validasi inputan dari form
        $request->validate([
            'kode_barang' => 'required|string|unique:products,kode_barang|max:255',
            'nama_barang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'lokasi_penyimpanan' => 'required|string|max:255',
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        // 2. Simpan data ke database
        Product::create([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'category_id' => $request->category_id,
            'stok' => $request->stok,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
            'kondisi_barang' => $request->kondisi_barang,
        ]);

        // 3. Kembalikan ke halaman daftar dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Barang baru berhasil ditambahkan ke inventaris!');
    }

    public function edit(Product $product)
    {
        // Ambil data kategori untuk form edit
        $categories = Category::all();
        // Buka halaman edit dan kirim data barang yang dipilih beserta daftar kategori
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, Product $product)
    {
        // 1. Validasi inputan (Perhatikan pengecualian unik untuk kode barang yang sedang diedit)
        $request->validate([
            'kode_barang' => 'required|string|max:255|unique:products,kode_barang,' . $product->id,
            'nama_barang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'lokasi_penyimpanan' => 'required|string|max:255',
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        // 2. Perbarui data di database
        $product->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'category_id' => $request->category_id,
            'stok' => $request->stok,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
            'kondisi_barang' => $request->kondisi_barang,
        ]);
    // 3. Kembali ke daftar barang
        return redirect()->route('products.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Hapus data dari database
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Data barang berhasil dihapus!');
    }
}