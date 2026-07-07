<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductApiController extends Controller
{
    public function index()
    {
        // Mengambil semua data barang beserta kategorinya
        $products = Product::with('category')->get();

        // Mengembalikan data dalam format JSON yang standar untuk REST API
        return response()->json([
            'success' => true,
            'message' => 'Berhasil mengambil data barang',
            'data'    => $products
        ], 200);
    }
}