<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    // ==========================================================
    // 1. TAMPILKAN ORDER (Dengan Fitur Search & Filter)
    // ==========================================================
    public function index(Request $request)
    {
        // Mulai Query
        $query = Order::with('user')->latest();

        // A. Logika Search (Cari berdasarkan ID Order atau Nama User)
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;

            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%$search%");
                    });
            });
        }

        // B. Logika Filter Waktu (7, 15, 30 Hari Terakhir)
        if ($request->has('filter') && $request->filter != '') {
            $days = $request->filter;
            if (in_array($days, ['7', '15', '30'])) {
                $query->where('created_at', '>=', now()->subDays($days));
            }
        }

        // Ambil Data dengan Pagination (10 per halaman)
        // withQueryString() berguna agar saat pindah halaman, filter tidak hilang
        $orders = $query->paginate(10)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    // ==========================================================
    // 2. FITUR EXPORT CSV (Baru)
    // ==========================================================
    public function export(Request $request)
    {
       
        $query = Order::with('user')->latest();

        // Filter Search
        if ($request->has('search') && $request->search != '') {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('id', 'LIKE', "%$search%")
                    ->orWhereHas('user', function ($u) use ($search) {
                        $u->where('name', 'LIKE', "%$search%");
                    });
            });
        }

        // Filter Tanggal
        if ($request->has('filter') && $request->filter != '') {
            $days = $request->filter;
            if (in_array($days, ['7', '15', '30'])) {
                $query->where('created_at', '>=', now()->subDays($days));
            }
        }

        // Ambil semua data (tanpa pagination)
        $orders = $query->get();

        // Persiapan File CSV
        $filename = 'laporan_transaksi_'.date('Y-m-d_H-i').'.csv';

        // Header agar browser langsung mendownload file
        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="'.$filename.'"');

        $handle = fopen('php://output', 'w');

        // Tulis Judul Kolom (Header CSV)
        fputcsv($handle, ['Order ID', 'Nama Customer', 'Email', 'Total Bayar', 'Status Bayar', 'Status Pengiriman', 'Tanggal Transaksi']);

        // Tulis Isi Data Baris per Baris
        foreach ($orders as $order) {
            fputcsv($handle, [
                $order->id,
                $order->user->name ?? 'Guest', // Cegah error jika user terhapus
                $order->user->email ?? '-',
                $order->total_price,
                $order->status,
                $order->delivery_status,
                $order->created_at->format('Y-m-d H:i:s'),
            ]);
        }

        fclose($handle);
        exit;
    }

    // ==========================================================
    // 3. UPDATE STATUS PENGIRIMAN
    // ==========================================================
    public function updateStatus(Request $request, $id)
    {
        $order = Order::findOrFail($id);

        $request->validate([
            'delivery_status' => 'required|in:pending,processing,shipping,completed,cancelled',
        ]);

        $order->update([
            'delivery_status' => $request->delivery_status,
        ]);

        return redirect()->back()->with('success', 'Status pengiriman berhasil diperbarui!');
    }

    // ==========================================================
    // 4. HAPUS ORDER
    // ==========================================================
    public function destroy($id)
    {
        $order = Order::findOrFail($id);
        $order->delete();

        return redirect()->back()->with('success', 'Data pesanan dihapus.');
    }
}
