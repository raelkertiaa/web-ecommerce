<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Midtrans\Config;
use Midtrans\Snap;

class OrderController extends Controller
{
    // =================================================
    // 1. TAMPILKAN HALAMAN FORM CHECKOUT (GET)
    // =================================================
    public function checkoutPage(Request $request)
    {
        // SKENARIO A: Checkout Langsung (Buy Now)
        if ($request->has('product_id')) {
            $product = Product::findOrFail($request->product_id);
            $quantity = $request->query('quantity', 1);

            $items = [
                (object) [
                    'product' => $product,
                    'quantity' => $quantity,
                    'price' => $product->price,
                ],
            ];

            $subtotal = $product->price * $quantity;
            $isCart = false;
        }

        // SKENARIO B: Checkout dari Keranjang
        else {
            $carts = Cart::query()->where('user_id', Auth::id())->get();

            if ($carts->isEmpty()) {
                return redirect()->route('home')->with('error', 'Keranjang kosong!');
            }

            $items = $carts;
            $subtotal = $carts->sum(fn ($c) => $c->product->price * $c->quantity);
            $isCart = true;
        }

        return view('checkout', compact('items', 'subtotal', 'isCart'));
    }

    // =================================================
    // 2. PROSES SIMPAN ORDER & BAYAR (POST)
    // =================================================
    public function processPayment(Request $request)
    {
        // 1. Validasi Data
        $request->validate([
            'address' => 'required|string',
            'courier' => 'required',
            'shipping_cost' => 'required|numeric',
        ]);

        // MULAI TRANSAKSI DATABASE (Safety)
        DB::beginTransaction();

        try {
            // 2. Persiapan Data Barang & Hitung Subtotal
            if ($request->is_cart == 'true') {
                $carts = Cart::query()->where('user_id', Auth::id())->with('product')->get(); // Eager load product
                $items = $carts;

                // Pastikan cart tidak kosong
                if ($items->isEmpty()) {
                    throw new \Exception('Keranjang belanja kosong.');
                }

                $subtotal = $carts->sum(fn ($c) => $c->product->price * $c->quantity);

                $productIdHead = $carts->first()->product_id;
                $qtyHead = $carts->sum('quantity');
            } else {
                // Ambil Produk langsung dari DB untuk data terbaru
                $productData = Product::findOrFail($request->product_id);

                // Format ulang agar strukturnya sama dengan object cart
                $items = [
                    (object) [
                        'product_id' => $productData->id, // Penting: simpan ID
                        'product' => $productData,
                        'quantity' => $request->quantity,
                        'price' => $productData->price,
                    ],
                ];
                $subtotal = $productData->price * $request->quantity;

                $productIdHead = $productData->id;
                $qtyHead = $request->quantity;
            }

            // 3. RUMUS BIAYA (DIBULATKAN)
            $shippingCost = $request->shipping_cost;
            $adminFee = 1000;
            $insuranceFee = 2500;
            $taxFee = round($subtotal * 0.11); // Pembulatan Pajak
            $grandTotal = $subtotal + $shippingCost + $taxFee + $insuranceFee + $adminFee;

            // 4. Simpan Order (Status Awal: Unpaid & Pending)
            $order = Order::create([
                'user_id' => Auth::id(),
                'recipient_name' => $request->recipient_name, // <-- Simpan ke kolom baru
                'total_price' => $grandTotal,
                'status' => 'Unpaid',
                'delivery_status' => 'pending',
                'product_id' => $productIdHead,
                'quantity' => $qtyHead,
                'shipping_address' => $request->address, // <-- Alamat kembali bersih
                'shipping_courier' => $request->courier,
                'shipping_cost' => $shippingCost,
                'tax_fee' => $taxFee,
                'insurance_fee' => $insuranceFee,
                'admin_fee' => $adminFee,
            ]);

            // 5. LOOPING ITEM: SIMPAN DETAIL & KURANGI STOK
            foreach ($items as $item) {
                // Ambil ID produk (handle beda struktur object vs model cart)
                $prodId = $item->product_id ?? $item->product->id;
                $qtyBeli = $item->quantity;

                // A. KUNCI PRODUK UTAMA (Mencegah Race Condition)
                $product = Product::lockForUpdate()->find($prodId);

                if (! $product) {
                    throw new \Exception('Produk tidak ditemukan.');
                }

                // B. CEK STOK
                if ($product->stock < $qtyBeli) {
                    throw new \Exception("Stok untuk produk '{$product->name}' tidak mencukupi! Sisa: {$product->stock}");
                }

                // C. KURANGI STOK
                $product->decrement('stock', $qtyBeli);

                // D. Simpan Order Item
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'quantity' => $qtyBeli,
                    'price' => $product->price,
                ]);
            }

            // 6. Hapus Keranjang (Jika beli dari keranjang)
            if ($request->is_cart == 'true') {
                Cart::query()->where('user_id', Auth::id())->delete();
            }

            // 7. Panggil Midtrans
            $this->getSnapToken($order);

            // Commit Transaksi (Simpan Permanen jika tidak ada error)
            DB::commit();

            return redirect()->route('history')->with('success', 'Order berhasil dibuat! Silakan bayar.');

        } catch (\Exception $e) {
            // Rollback (Batalkan semua perubahan jika ada error)
            DB::rollBack();

            return redirect()->back()->with('error', 'Gagal memproses pesanan: '.$e->getMessage());
        }
    }

    // =================================================
    // 3. HISTORY & TIMEOUT
    // =================================================
    public function history(Request $request)
    {
        // A. Logika Hapus Otomatis (Timeout 1 Menit) & KEMBALIKAN STOK
        $expiredOrders = Order::query()->where('status', 'Unpaid')
            ->where('created_at', '<', now()->subMinute())
            ->with('orderItems') // Load itemnya
            ->get();

        foreach ($expiredOrders as $expired) {
            // KEMBALIKAN STOK BARANG (Restock)
            foreach ($expired->orderItems as $item) {
                Product::query()->where('id', $item->product_id)->increment('stock', $item->quantity);
            }
            // Baru hapus ordernya
            $expired->delete();
        }

        // B. Tampilkan Data
        $orders = Order::query()->where('user_id', Auth::id())
            ->with('orderItems.product')
            ->latest()
            ->get();

        return view('history', compact('orders'));
    }

    // =================================================
    // 4. MANUAL PAID (Route Khusus Demo)
    // =================================================
    public function markAsPaid(string $id)
    {
        $order = Order::findOrFail($id);

        $order->update([
            'status' => 'Paid',
            'delivery_status' => 'processing',
        ]);

        return redirect()->route('history')->with('success', 'Pembayaran Berhasil! Pesanan sedang dikemas.');
    }

    // ==========================================================
    // 5. SIMULASI KIRIM BARANG (Tombol Admin)
    // ==========================================================
    public function markAsShipped(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->status == 'Paid' && $order->delivery_status == 'processing') {
            $order->update(['delivery_status' => 'shipping']);

            return redirect()->back()->with('success', 'Status berubah: Barang sedang dikirim!');
        }

        return redirect()->back()->with('error', 'Pesanan belum siap dikirim.');
    }

    // ==========================================================
    // 6. TERIMA PESANAN (Tombol User)
    // ==========================================================
    public function receiveOrder(string $id)
    {
        $order = Order::findOrFail($id);

        if ($order->delivery_status == 'shipping') {
            $order->update(['delivery_status' => 'completed']);

            return redirect()->back()->with('success', 'Terima kasih! Transaksi selesai.');
        }

        return redirect()->back()->with('error', 'Barang belum dikirim, tidak bisa diterima.');
    }

    // =================================================
    // 7. WEBHOOK / CALLBACK DARI MIDTRANS (BACKGROUND)
    // =================================================
    public function callback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        // Buat enkripsi verifikasi SHA512 sesuai standar Midtrans
        $hashed = hash('sha512', $request->order_id.$request->status_code.$request->gross_amount.$serverKey);

        if ($hashed == $request->signature_key) {
            $parts = explode('-', $request->order_id);
            if (count($parts) >= 2) {
                // Ambil ID order utama dari susunan string parameter order_id
                $order = Order::find($parts[1]);

                if ($order) {
                    if ($request->transaction_status == 'capture' || $request->transaction_status == 'settlement') {
                        $order->update([
                            'status' => 'Paid',
                            'delivery_status' => 'processing',
                        ]);
                    } elseif (in_array($request->transaction_status, ['cancel', 'deny', 'expire'])) {
                        $order->update(['status' => 'Failed']);

                        // Kembalikan stok produk jika transaksi gagal/hangus di sistem Midtrans
                        foreach ($order->orderItems as $item) {
                            Product::query()->where('id', $item->product_id)->increment('stock', $item->quantity);
                        }
                    } elseif ($request->transaction_status == 'pending') {
                        $order->update(['status' => 'Unpaid']);
                    }
                }
            }
        }

        return response()->json(['message' => 'Callback diterima']);
    }

    // =================================================
    // HELPER MIDTRANS
    // =================================================
    private function getSnapToken($order)
    {
        Config::$serverKey = config('services.midtrans.server_key');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $params = [
            'transaction_details' => [
                'order_id' => 'ORD-'.$order->id.'-'.time(),
                'gross_amount' => (int) $order->total_price,
            ],
            'customer_details' => [
                'first_name' => Auth::user()->name,
                'email' => Auth::user()->email,
                'billing_address' => [
                    'address' => $order->shipping_address,
                ],
            ],
        ];

        $order->snap_token = Snap::getSnapToken($params);
        $order->save();
    }
}
