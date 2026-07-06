<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['borrowing_id', 'product_id', 'status_barang'])]
class BorrowingDetail extends Model
{
    use HasFactory;

    // Relasi balik ke Transaksi Induknya
    public function borrowing()
    {
        return $this->belongsTo(Borrowing::class, 'borrowing_id');
    }

    // Relasi ke Barang: Barang apa yang ada di baris detail ini?
    public function product()
    {
        return $this->belongsTo(Product::class, 'product_id');
    }
}