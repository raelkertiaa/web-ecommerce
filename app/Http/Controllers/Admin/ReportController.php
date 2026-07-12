<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ReportController extends Controller
{
    // 1. HALAMAN UTAMA LAPORAN
    public function index(Request $request)
    {
        // Default: Tanggal awal bulan ini s/d hari ini
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth()->format('Y-m-d'));
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth()->format('Y-m-d'));

        $query = Order::where('status', 'Paid')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with('user');

        $orders = $query->latest()->get();

        // Hitung Ringkasan
        $totalRevenue = $orders->sum('total_price');
        $totalItemsSold = $orders->sum('quantity'); 

        return view('admin.reports.index', compact('orders', 'startDate', 'endDate', 'totalRevenue', 'totalItemsSold'));
    }

    // 2. EXPORT KE EXCEL (CSV)
    public function export(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = Order::where('status', 'Paid')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->with('user')
            ->latest()
            ->get();

        $filename = "Laporan_Keuangan_$startDate-sd-$endDate.csv";

        header('Content-Type: text/csv');
        header('Content-Disposition: attachment; filename="' . $filename . '"');

        $handle = fopen('php://output', 'w');
        fputcsv($handle, ['Order ID', 'Tanggal', 'Customer', 'Jml Barang', 'Status Kirim', 'Total Pendapatan']);

        foreach ($orders as $order) {
            fputcsv($handle, [
                '#' . $order->id,
                $order->created_at->format('d M Y'),
                $order->user->name ?? 'Guest',
                $order->quantity,
                $order->delivery_status,
                $order->total_price
            ]);
        }
        
        // Baris Total di paling bawah
        fputcsv($handle, ['', '', '', '', 'TOTAL PENDAPATAN', $orders->sum('total_price')]);

        fclose($handle);
        exit;
    }

    // 3. CETAK / PREVIEW PDF (Print Friendly View)
    public function print(Request $request)
    {
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');

        $orders = Order::where('status', 'Paid')
            ->whereDate('created_at', '>=', $startDate)
            ->whereDate('created_at', '<=', $endDate)
            ->get();

        $totalRevenue = $orders->sum('total_price');
        $totalItemsSold = $orders->sum('quantity');

        return view('admin.reports.print', compact('orders', 'startDate', 'endDate', 'totalRevenue', 'totalItemsSold'));
    }
}