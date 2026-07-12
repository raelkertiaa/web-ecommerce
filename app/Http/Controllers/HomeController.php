<?php

namespace App\Http\Controllers;

use App\Models\Product; // Wajib import ini untuk menangkap Filter/Search
use Illuminate\Http\Request;

class HomeController extends Controller
{
    public function index(Request $request)
    {
        // 1. Mulai Query 
        $query = Product::latest();

        // 2. LOGIKA FILTER KATEGORI
        // Cek apakah di URL ada ?category=fashion
        if ($request->has('category') && $request->category != '') {
            $category = $request->category;

            // Saring data berdasarkan kolom 'category' di database
            $query->where('category', $category);
        }

        // 3. LOGIKA SEARCH (Pencarian Nama)
        // Cek apakah di URL ada ?search=gundam
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where('name', 'LIKE', '%'.$search.'%');
        }

        // 4. Eksekusi Query
        $products = $query->get();

        // Kirim data ke view 'welcome'
        return view('welcome', compact('products'));
    }

    public function show($id)
    {
        // Cari produk, kalau gak ada error 404
        // Kita tambahkan with('reviews') agar ulasan langsung ikut terambil
        $product = Product::with('reviews')->findOrFail($id);

        return view('detail', compact('product'));
    }
}
