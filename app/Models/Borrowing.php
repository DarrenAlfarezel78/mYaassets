<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'])]
class Borrowing extends Model
{
    use HasFactory;

    // Relasi ke User: Transaksi ini milik siapa?
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    // Relasi ke Detail: Satu transaksi bisa punya banyak barang
    public function details()
    {
        return $this->hasMany(BorrowingDetail::class, 'borrowing_id');
    }
}