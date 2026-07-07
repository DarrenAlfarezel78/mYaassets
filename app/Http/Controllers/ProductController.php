<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        // 1. Validasi inputan dari form (ditambah validasi untuk gambar)
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|unique:products,kode_barang|max:255',
            'nama_barang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'lokasi_penyimpanan' => 'required|string|max:255',
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048', // Maksimal 2MB
        ]);

        // 2. Cek apakah ada file gambar yang diupload
        if ($request->hasFile('gambar')) {
            // Simpan gambar ke folder storage/app/public/products
            $validatedData['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        // 3. Simpan data ke database
        \App\Models\Product::create($validatedData);

        // 4. Kembalikan ke halaman daftar dengan pesan sukses
        return redirect()->route('products.index')->with('success', 'Barang baru berhasil ditambahkan beserta gambarnya!');
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
        // 1. Validasi Input
        $validatedData = $request->validate([
            'kode_barang' => 'required|string|unique:products,kode_barang,'.$id, 
            'nama_barang' => 'required|string|max:255',
            'category_id' => 'required|exists:categories,id',
            'stok' => 'required|integer|min:0',
            'lokasi_penyimpanan' => 'required|string|max:255',
            'kondisi_barang' => 'required|in:Baik,Rusak Ringan,Rusak Berat',
            'gambar' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
        ]);

        // 2. Cari data lama
        $product = \App\Models\Product::findOrFail($id);

        // 3. Cek apakah user mengupload gambar baru saat diedit
        if ($request->hasFile('gambar')) {
            // Hapus gambar lama dari server jika sebelumnya sudah ada gambar
            if ($product->gambar && Storage::disk('public')->exists($product->gambar)) {
                Storage::disk('public')->delete($product->gambar);
            }
            // Simpan gambar yang baru
            $validatedData['gambar'] = $request->file('gambar')->store('products', 'public');
        }

        // 4. Perbarui data di database
        $product->update($validatedData);

        // 5. Kembali ke halaman daftar barang
        return redirect()->route('products.index')->with('success', 'Data barang berhasil diperbarui!');
    }

    public function destroy(Product $product)
    {
        // Hapus data dari database
        $product->delete();
        
        return redirect()->route('products.index')->with('success', 'Data barang berhasil dihapus!');
    }
}