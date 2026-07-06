<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

class Product extends Model
{
    use HasFactory;

    // Kolom yang boleh diisi
    protected $fillable = [
        'kode_barang', 
        'nama_barang', 
        'category_id', 
        'stok', 
        'lokasi_penyimpanan', 
        'kondisi_barang'
    ];

    // Relasi ke tabel Category (Satu barang punya satu kategori)
    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}