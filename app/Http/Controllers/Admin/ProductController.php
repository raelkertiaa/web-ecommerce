<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    // 1. TAMPILKAN DAFTAR PRODUK (INDEX)
    public function index(Request $request)
    {
        // Mulai query produk terbaru
        $query = Product::latest();

        // Cek apakah ada pencarian?
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            // Filter berdasarkan nama produk (mirip dengan pencarian SQL LIKE)
            $query->where('name', 'LIKE', '%'.$search.'%');
        }

        
        $products = $query->paginate(10);

        return view('admin.products.index', compact('products'));
    }

    // 2. HALAMAN TAMBAH PRODUK (CREATE)
    public function create()
    {
        return view('admin.products.create');
    }

    // 3. PROSES SIMPAN PRODUK (STORE)
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ]);

        // Upload Gambar
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('products', 'public');
        }

        Product::create([
            'name' => $request->name,
            'category' => $request->category,
            'price' => $request->price,
            'stock' => $request->stock,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil ditambahkan!');
    }

    // 4. HALAMAN EDIT PRODUK
    public function edit($id)
    {
        $product = Product::findOrFail($id);

        return view('admin.products.edit', compact('product'));
    }

    // 5. PROSES UPDATE DATA
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|string',
            'price' => 'required|numeric',
            'stock' => 'required|integer',
            'description' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp,svg|max:10240',
        ]);

        // Ambil data inputan dasar
        $data = $request->only(['name', 'category', 'price', 'stock', 'description']);

        // Cek apakah ada upload gambar baru?
        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($product->image && Storage::disk('public')->exists($product->image)) {
                Storage::disk('public')->delete($product->image);
            }
            // Simpan gambar baru
            $data['image'] = $request->file('image')->store('products', 'public');
        }

        $product->update($data);

        return redirect()->route('admin.products.index')->with('success', 'Produk berhasil diperbarui!');
    }

    // 6. PROSES HAPUS PRODUK (DESTROY)
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

    
        if ($product->image && Storage::disk('public')->exists($product->image)) {
            Storage::disk('public')->delete($product->image);
        }

        $product->delete();

        return redirect()->back()->with('success', 'Produk berhasil dihapus!');
    }
}
