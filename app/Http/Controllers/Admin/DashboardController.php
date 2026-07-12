<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;

class DashboardController extends Controller
{
    public function index()
    {
        // 1. DATA KARTU STATISTIK
        $totalRevenue = Order::query()->where('status', 'Paid')->sum('total_price');
        $totalOrders = Order::query()->count('id');
        $totalProducts = Product::query()->count('id');
        $totalUsers = \App\Models\User::query()->count('id');

        // 2. DATA PRODUK TERLARIS (Top 5)
        $topProducts = Product::query()->select('products.id', 'products.name', 'products.price', 'products.image')
            ->join('order_items', 'products.id', '=', 'order_items.product_id')
            ->join('orders', 'orders.id', '=', 'order_items.order_id')
            ->where('orders.status', 'Paid')
            ->selectRaw('products.*, SUM(order_items.quantity) as total_sold')
            ->groupBy('products.id')
            ->orderByDesc('total_sold')
            ->take(5)
            ->get();

        // 3. DATA GRAFIK (Pendapatan & Pesanan per Bulan) - Opsional biar grafik gerak
        $salesData = Order::query()->selectRaw('MONTH(created_at) as month, SUM(total_price) as total')
            ->where('status', 'Paid')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();

        $ordersData = Order::query()->selectRaw('MONTH(created_at) as month, COUNT(*) as total')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->pluck('total', 'month')->toArray();

        // array kosong untuk 12 bulan
        $chartSales = array_fill(1, 12, 0);
        $chartOrders = array_fill(1, 12, 0);

        // Isi data yang ada
        foreach ($salesData as $month => $total) {
            $chartSales[$month] = $total;
        }
        foreach ($ordersData as $month => $total) {
            $chartOrders[$month] = $total;
        }

        return view('admin.dashboard', compact(
            'totalRevenue', 'totalOrders', 'totalProducts', 'totalUsers',
            'topProducts', 'chartSales', 'chartOrders'
        ));
    }
}
