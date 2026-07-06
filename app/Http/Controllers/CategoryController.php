<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil semua data kategori dari database
        $categories = \App\Models\Category::all();
        
        // Tampilkan ke halaman view 'categories/index.blade.php' dengan membawa data
        return view('categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Tampilkan halaman form tambah kategori
        return view('categories.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi inputan
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // Simpan ke database
        Category::create([
            'nama_kategori' => $request->nama_kategori,
        ]);

        // Kembalikan ke halaman sebelumnya dengan pesan sukses
        return redirect()->route('categories.index')->with('success', 'Kategori berhasil ditambahkan!');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        // Cari data kategori berdasarkan ID, lalu kirim ke halaman form edit
        $category = \App\Models\Category::findOrFail($id);
        return view('categories.edit', compact('category'));
    }

    public function update(Request $request, $id)
    {
        // 1. Validasi input
        $request->validate([
            'nama_kategori' => 'required|string|max:255',
        ]);

        // 2. Cari data yang mau diedit, lalu simpan perubahan
        $category = \App\Models\Category::findOrFail($id);
        $category->update([
            'nama_kategori' => $request->nama_kategori,
        ]);

        return redirect()->route('categories.index');
    }

    public function destroy($id)
    {
        // Cari data berdasarkan ID, lalu hapus dari database
        $category = \App\Models\Category::findOrFail($id);
        $category->delete();

        return redirect()->route('categories.index');
    }
}
