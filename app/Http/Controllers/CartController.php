<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    // Menampilkan isi keranjang
    public function index()
    {
        $carts = Cart::where('user_id', Auth::id())->with('product')->get();

        return view('cart.index', compact('carts'));
    }

    // Tambah barang ke keranjang
    public function store(Request $request, $id)
    {
        // 1. Ambil jumlah dari input (kalau kosong default 1)
        $quantity = $request->input('quantity', 1);

        $existingCart = Cart::where('user_id', Auth::id())
            ->where('product_id', $id)
            ->first();

        if ($existingCart) {
            $existingCart->quantity += $quantity;
            $existingCart->save();
        } else {
            Cart::create([
                'user_id' => Auth::id(),
                'product_id' => $id,
                'quantity' => $quantity,
            ]);
        }

        return redirect()->back()->with('success', 'Barang masuk keranjang!');
    }

    // Hapus barang dari keranjang
    public function destroy($id)
    {
        Cart::destroy($id);

        return redirect()->back();
    }
    
    // Update jumlah barang (Tambah/Kurang)
    public function update(Request $request, $id)
    {
        $cart = Cart::query()->with('product')->findOrFail($id);
        $action = $request->input('action'); // Menangkap aksi dari tombol '+' atau '-'

        if ($action == 'increase') {
            // Cek apakah jumlah saat ini masih di bawah stok produk
            if ($cart->quantity < $cart->product->stock) {
                $cart->increment('quantity');
                return redirect()->back()->with('success', 'Jumlah barang ditambahkan.');
            } else {
                return redirect()->back()->with('error', 'Gagal: Jumlah melebihi stok yang tersedia!');
            }
        } 
        
        elseif ($action == 'decrease') {
            // Cek apakah jumlah saat ini lebih dari 1
            if ($cart->quantity > 1) {
                $cart->decrement('quantity');
                return redirect()->back()->with('success', 'Jumlah barang dikurangi.');
            } else {
                return redirect()->back()->with('error', 'Gagal: Minimal pembelian adalah 1!');
            }
        }

        return redirect()->back();
    }
}
