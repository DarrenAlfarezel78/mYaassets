<?php

use App\Http\Middleware\CheckRole;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\BorrowingController; // Tambahkan import ini agar rapi
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Semua role bisa masuk ke Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Fitur Master Data & Transaksi (HANYA boleh diakses oleh Admin & Staff)
    // Cukup jadikan satu grup middleware di sini agar tidak ada duplikasi
    Route::middleware([CheckRole::class.':Admin,Staff'])->group(function () {
        
        // Rute Kategori & Barang
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
        
        // Rute Peminjaman
        Route::get('borrowings', [BorrowingController::class, 'index'])->name('borrowings.index');
        Route::get('borrowings/create', [BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('borrowings', [BorrowingController::class, 'store'])->name('borrowings.store');
        
        // Rute khusus pengembalian barang (Wajib menggunakan PUT sesuai form HTML)
        Route::put('borrowings/{id}/return', [BorrowingController::class, 'returnAsset'])->name('borrowings.return');
    });
});

require __DIR__.'/auth.php';