<?php

namespace App\Http\Controllers;

use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReviewController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'order_id' => 'required|exists:orders,id', // Validasi Order ID
            'rating' => 'required|integer|min:1|max:5',
            'comment' => 'nullable|string',
        ]);

        // CEK DUPLIKAT SPESIFIK ORDER INI
        // "Apakah user ini, sudah mereview produk ini, DI ORDER INI?"
        $existingReview = Review::where('user_id', Auth::id())
            ->where('product_id', $request->product_id)
            ->where('order_id', $request->order_id) // <--- KUNCI PERBAIKANNYA
            ->first();

        if ($existingReview) {
            return redirect()->back()->with('error', 'Anda sudah menilai transaksi ini!');
        }

        Review::create([
            'user_id' => Auth::id(),
            'product_id' => $request->product_id,
            'order_id' => $request->order_id, // Simpan ID Order
            'rating' => $request->rating,
            'comment' => $request->comment,
        ]);

        return redirect()->back()->with('success', 'Terima kasih atas penilaian Anda!');
    }
}
