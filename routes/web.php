<?php

use App\Http\Middleware\CheckRole;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BorrowingController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Semua role bisa masuk ke Dashboard
    Route::get('/dashboard', [BorrowingController::class, 'dashboard'])->name('dashboard');

    // Route Riwayat Peminjaman (Diletakkan di sini agar Manager nanti bisa akses sebagai laporan)
    Route::get('/borrowings/history', [BorrowingController::class, 'history'])->name('borrowings.history');

    // Route Bonus: Export PDF Laporan
    Route::get('/borrowings/export-pdf', [BorrowingController::class, 'exportPdf'])->name('borrowings.pdf');

    // Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Fitur Master Data & Transaksi (HANYA boleh diakses oleh Admin & Staff)
    Route::middleware([CheckRole::class.':Admin,Staff'])->group(function () {
        
        // Rute Kategori & Barang
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        
        // Rute Peminjaman
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
        
        // Route untuk memproses pengembalian barang
        Route::patch('/borrowings/{borrowing}/return', [BorrowingController::class, 'returnItem'])->name('borrowings.return');
    });
});

require __DIR__.'/auth.php';