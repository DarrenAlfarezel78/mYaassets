<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

// Sesuaikan nama kolom dengan yang ada di file migrasi kategori milikmu (misalnya 'nama_kategori')
#[Fillable(['nama_kategori'])] 
class Category extends Model
{
    use HasFactory;

    // Relasi: Satu Kategori bisa memiliki banyak Barang (Products)
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
    }
}