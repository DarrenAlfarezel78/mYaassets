<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Menangkap inputan pencarian dari user
        $search = $request->input('search');

        // Query data barang beserta relasi kategorinya
        $products = \App\Models\Product::with('category')
            ->when($search, function ($query, $search) {
                return $query->where('nama_barang', 'like', "%{$search}%")
                             ->orWhere('kode_barang', 'like', "%{$search}%");
            })
            // Gunakan paginate() dengan memori pencarian agar halaman selanjutnya tidak reset
            ->paginate(10)->withQueryString();

        return view('products.index', compact('products', 'search'));
    }

    public function create()
    {
        // Ambil data kategori untuk ditampilkan di pilihan (dropdown) form tambah barang
        $categories = \App\Models\Category::all();
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
        \App\Models\Product::create([
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

    public function edit($id)
    {
        // Cari barang yang mau diedit
        $product = \App\Models\Product::findOrFail($id);
        
        // Ambil juga data kategori untuk mengisi menu dropdown
        $categories = \App\Models\Category::all();
        
        return view('products.edit', compact('product', 'categories'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi Input (Perhatikan pengecualian untuk kode_barang unik)
        $request->validate([
            'kode_barang' => 'required|string|unique:products,kode_barang,'.$id, 
            'nama_barang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'lokasi_penyimpanan' => 'required|string|max:255',
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
        ]);

        // 2. Cari data lama dan perbarui dengan data baru
        $product = \App\Models\Product::findOrFail($id);
        $product->update([
            'kode_barang' => $request->kode_barang,
            'nama_barang' => $request->nama_barang,
            'category_id' => $request->category_id,
            'stok' => $request->stok,
            'lokasi_penyimpanan' => $request->lokasi_penyimpanan,
            'kondisi_barang' => $request->kondisi_barang,
        ]);

        // 3. Kembali ke halaman daftar barang
        return redirect()->route('products.index');
    }

    public function destroy(Product $product)
    {
        // Hapus data dari database
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Data barang berhasil dihapus!');
    }
}