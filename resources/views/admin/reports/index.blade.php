@extends('layouts.admin')

@section('title', 'Laporan Keuangan')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Laporan Penjualan</h2>
        </div>

        <div class="mb-8 rounded-lg border border-gray-200 bg-white p-6 shadow-sm">
            <form action="{{ route('admin.reports.index') }}" method="GET"
                class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-end">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Dari Tanggal</label>
                    <input type="date" name="start_date" value="{{ $startDate }}"
                        class="w-full rounded border-gray-300 px-3 py-2 outline-none focus:border-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Sampai Tanggal</label>
                    <input type="date" name="end_date" value="{{ $endDate }}"
                        class="w-full rounded border-gray-300 px-3 py-2 outline-none focus:border-blue-500">
                </div>
                <div class="flex gap-2">
                    <button type="submit"
                        class="rounded bg-blue-600 px-6 py-2.5 font-medium text-white hover:bg-blue-700 transition">
                        Tampilkan
                    </button>
                </div>
            </form>

            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2">
                <div class="rounded-lg bg-green-50 p-4 border border-green-100">
                    <h4 class="text-sm font-semibold text-green-600">Total Pendapatan (Periode Ini)</h4>
                    <p class="text-2xl font-bold text-green-700">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</p>
                </div>
                <div class="rounded-lg bg-blue-50 p-4 border border-blue-100">
                    <h4 class="text-sm font-semibold text-blue-600">Barang Terjual</h4>
                    <p class="text-2xl font-bold text-blue-700">{{ $totalItemsSold }} <span
                            class="text-sm font-normal text-blue-500">Pcs</span></p>
                </div>
            </div>
        </div>

        <div class="mb-4 flex gap-2 justify-end">
            <a href="{{ route('admin.reports.export', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                class="inline-flex items-center gap-2 rounded bg-green-600 px-4 py-2 font-medium text-white hover:bg-green-700">
                Export Excel (CSV)
            </a>
            <a href="{{ route('admin.reports.print', ['start_date' => $startDate, 'end_date' => $endDate]) }}"
                target="_blank"
                class="inline-flex items-center gap-2 rounded bg-slate-700 px-4 py-2 font-medium text-white hover:bg-slate-800">
                Cetak PDF
            </a>
        </div>

        <div class="rounded-lg border border-gray-200 bg-white shadow-sm overflow-hidden">
            <table class="w-full text-left border-collapse">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-4 px-4 font-medium text-black">Tanggal</th>
                        <th class="py-4 px-4 font-medium text-black">Order ID</th>
                        <th class="py-4 px-4 font-medium text-black">Customer</th>
                        <th class="py-4 px-4 font-medium text-black">Jml Barang</th>
                        <th class="py-4 px-4 font-medium text-black">Total</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($orders as $order)
                        <tr class="border-t border-gray-200 hover:bg-gray-50">
                            <td class="py-3 px-4">{{ $order->created_at->format('d M Y') }}</td>
                            <td class="py-3 px-4 font-bold">#{{ $order->id }}</td>
                            <td class="py-3 px-4">{{ $order->user->name ?? 'Guest' }}</td>
                            <td class="py-3 px-4">{{ $order->quantity }} Item</td>
                            <td class="py-3 px-4 font-bold text-green-600">Rp
                                {{ number_format($order->total_price, 0, ',', '.') }}</td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" class="py-6 text-center text-gray-500">Tidak ada transaksi pada periode ini.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
                @if ($orders->isNotEmpty())
                    <tfoot class="bg-gray-50 border-t-2 border-gray-200">
                        <tr>
                            <td colspan="4" class="py-4 px-4 text-right font-bold text-black">TOTAL PENDAPATAN:</td>
                            <td class="py-4 px-4 font-bold text-xl text-blue-600">Rp
                                {{ number_format($totalRevenue, 0, ',', '.') }}</td>
                        </tr>
                    </tfoot>
                @endif
            </table>
        </div>

    </div>
@endsection
