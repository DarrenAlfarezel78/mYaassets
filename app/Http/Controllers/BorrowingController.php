<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Borrowing extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'tanggal_pinjam', 'tanggal_kembali', 'status'];

    // Menghubungkan ke user (siapa yang meminjam/staf yang menginput)
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Menghubungkan ke detail barang yang dipinjam
    public function details()
    {
        return $this->hasMany(BorrowingDetail::class);
    }
}