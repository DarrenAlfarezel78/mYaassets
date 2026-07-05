<?php

use App\Http\Middleware\CheckRole;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\ProductController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::middleware(['auth', 'verified'])->group(function () {
    
    // Semua role bisa masuk ke Dashboard
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');

    // Fitur Master Data Barang (HANYA boleh diakses oleh Admin & Staff)
    Route::middleware(['role:Admin,Staff'])->group(function () {
        Route::resource('categories', CategoryController::class);
        Route::resource('products', ProductController::class);
    });

    // Profil Bawaan Breeze
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    
    // Fitur untuk Admin & Staff
    Route::middleware(['auth', CheckRole::class.':Admin,Staff'])->group(function () {
        Route::resource('categories', App\Http\Controllers\CategoryController::class);
        Route::resource('products', App\Http\Controllers\ProductController::class);
        
        Route::get('borrowings', [App\Http\Controllers\BorrowingController::class, 'index'])->name('borrowings.index');
        Route::get('borrowings/create', [App\Http\Controllers\BorrowingController::class, 'create'])->name('borrowings.create');
        Route::post('borrowings', [App\Http\Controllers\BorrowingController::class, 'store'])->name('borrowings.store');
        Route::post('borrowings/{id}/return', [App\Http\Controllers\BorrowingController::class, 'returnAsset'])->name('borrowings.return');
    });
});


require __DIR__.'/auth.php';
