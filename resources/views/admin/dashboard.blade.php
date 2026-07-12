@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')
    <div class="grid grid-cols-1 gap-4 md:grid-cols-2 md:gap-6 xl:grid-cols-3 2xl:gap-7.5 mb-8">

        <div
            class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-sm flex flex-col items-center justify-center text-center">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-blue-50 text-blue-600 mb-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-black">{{ \App\Models\User::count() }}</h4>
                <span class="text-sm font-medium text-slate-500">Total User</span>
            </div>
        </div>

        @php
            $totalRevenue = \App\Models\Order::where('status', 'Paid')->sum('total_price');
        @endphp
        <div
            class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-sm flex flex-col items-center justify-center text-center">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-green-50 text-green-600 mb-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-black">Rp {{ number_format($totalRevenue, 0, ',', '.') }}</h4>
                <span class="text-sm font-medium text-slate-500">Total Pendapatan</span>
            </div>
        </div>

        <div
            class="rounded-sm border border-stroke bg-white py-6 px-7.5 shadow-sm flex flex-col items-center justify-center text-center">
            <div class="flex h-11.5 w-11.5 items-center justify-center rounded-full bg-blue-50 text-blue-600 mb-4">
                <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                </svg>
            </div>
            <div>
                <h4 class="text-2xl font-bold text-black">{{ \App\Models\Product::count() }}</h4>
                <span class="text-sm font-medium text-slate-500">Total Produk</span>
            </div>
        </div>
    </div>

    <div class="mt-4 grid grid-cols-12 gap-4 md:mt-6 md:gap-6 2xl:mt-7.5 2xl:gap-7.5">

        <div class="col-span-12 rounded-sm border border-stroke bg-white px-5 pt-7.5 pb-5 shadow-sm sm:px-7.5 xl:col-span-8">
            <div class="flex flex-wrap items-start justify-between gap-3 sm:flex-nowrap mb-6">
                <div class="flex w-full flex-wrap gap-3 sm:gap-5">
                    <h4 class="text-xl font-bold text-black">Statistik Penjualan</h4>
                </div>
            </div>

            <div id="chartOne" class="-ml-5"></div>
        </div>

        <div class="col-span-12 rounded-lg border border-gray-200 bg-white p-6 shadow-sm xl:col-span-4">
            <div class="mb-6 flex items-center justify-between">
                <h4 class="text-xl font-bold text-slate-800">Produk Terlaris</h4>
                <span class="rounded bg-blue-100 px-2 py-1 text-xs font-medium text-blue-600">Top 5</span>
            </div>

            <div class="flex flex-col gap-4">
                @forelse($topProducts as $index => $product)
                    <div class="group relative flex items-center gap-4 rounded-lg border border-gray-100 bg-gray-50 p-4 transition-all hover:bg-white hover:shadow-md hover:border-blue-200">
                        <div class="absolute -left-2 -top-2 flex h-6 w-6 items-center justify-center rounded-full bg-slate-700 text-xs font-bold text-white shadow-sm">
                            {{ $index + 1 }}
                        </div>
                        <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200 bg-white">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="h-full w-full object-cover transition duration-300 group-hover:scale-110">
                            @else
                                <div class="flex h-full w-full items-center justify-center bg-gray-100 text-gray-400">
                                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                        </path>
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex flex-1 flex-col justify-center">
                            <h5 class="text-sm font-bold text-slate-800 line-clamp-1" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h5>
                            <div class="mt-1 flex items-center justify-between">
                                <span class="text-xs font-medium text-slate-500">
                                    Harga: <span class="text-slate-700">Rp {{ number_format($product->price, 0, ',', '.') }}</span>
                                </span>
                                <span class="rounded-full bg-green-100 px-2 py-0.5 text-xs font-bold text-green-700">
                                    {{ $product->total_sold }} Terjual
                                </span>
                            </div>
                        </div>
                    </div>
                @empty
                    <div class="flex flex-col items-center justify-center rounded-lg border border-dashed border-gray-300 py-8 text-center">
                        <p class="text-sm text-gray-500">Belum ada penjualan</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    <div class="mt-8 rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7.5 xl:pb-1">
        <h4 class="mb-6 text-xl font-bold text-black">Transaksi Terbaru</h4>
        <div class="flex flex-col">
            <div class="grid grid-cols-3 rounded-sm bg-gray-100 sm:grid-cols-5 p-2.5">
                <div class="p-2.5 xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Produk</h5></div>
                <div class="p-2.5 text-center xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Tanggal</h5></div>
                <div class="p-2.5 text-center xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Harga</h5></div>
                <div class="hidden p-2.5 text-center sm:block xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Status</h5></div>
                <div class="hidden p-2.5 text-center sm:block xl:p-5"><h5 class="text-sm font-medium uppercase xsm:text-base">Aksi</h5></div>
            </div>

            @foreach (\App\Models\Order::latest()->take(5)->get() as $order)
                <div class="grid grid-cols-3 border-b border-stroke sm:grid-cols-5 p-2.5 hover:bg-gray-50 transition">
                    <div class="flex items-center gap-3 p-2.5 xl:p-5">
                        <p class="hidden text-black sm:block font-medium text-sm">Order #{{ $order->id }}</p>
                    </div>
                    <div class="flex items-center justify-center p-2.5 xl:p-5">
                        <p class="text-black text-sm">{{ $order->created_at->format('d M Y') }}</p>
                    </div>
                    <div class="flex items-center justify-center p-2.5 xl:p-5">
                        <p class="text-green-600 font-bold text-sm">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>
                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                        <p class="inline-flex rounded-full bg-opacity-10 py-1 px-3 text-sm font-medium {{ $order->status == 'Paid' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">
                            {{ $order->status }}
                        </p>
                    </div>
                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                        <a href="{{ route('admin.orders.index') }}" class="text-sm hover:text-blue-500">Detail</a>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var options = {
                series: [{
                    name: 'Pendapatan',
                    data: @json(array_values(array_map(fn($val) => $val / 1000000, $chartSales)))
                }, {
                    name: 'Total Pesanan',
                    data: @json(array_values($chartOrders))
                }],
                chart: {
                    type: 'area',
                    height: 350,
                    toolbar: { show: false }
                },
                colors: ['#3C50E0', '#80CAEE'],
                stroke: {
                    curve: 'smooth',
                    width: 2,
                },
                fill: {
                    type: 'gradient',
                    gradient: {
                        opacityFrom: 0.55,
                        opacityTo: 0,
                    }
                },
                dataLabels: { enabled: false },
                
                // 1. CONFIG X-AXIS (Bagian Bawah)
                xaxis: {
                    categories: @json(array_keys($chartSales)), // Ini mengirim angka 1, 2, 3...
                    axisBorder: { show: false },
                    axisTicks: { show: false },
                    labels: {
                        // Formatter untuk mengubah Angka (1-12) menjadi Nama Bulan (Jan-Des)
                        formatter: function (val) {
                            const monthNames = ["Jan", "Feb", "Mar", "Apr", "Mei", "Jun", "Jul", "Agu", "Sep", "Okt", "Nov", "Des"];
                            // val - 1 karena array mulai dari 0, sedangkan bulan dari 1
                            return monthNames[val - 1] || val;
                        }
                    }
                },

                // 2. CONFIG Y-AXIS (Kiri & Kanan)
                yaxis: [
                    {
                        title: { text: 'Pendapatan (Jutaan)' },
                        labels: {
                            formatter: function (value) {
                                return value.toFixed(1); // Angka desimal pendek (15.5)
                            }
                        }
                    },
                    {
                        opposite: true,
                        title: { text: 'Total Pesanan' },
                        labels: {
                            formatter: function (value) {
                                return value.toFixed(0); // Angka bulat (24)
                            }
                        }
                    }
                ],

                // 3. CONFIG TOOLTIP (Popup Hover)
                tooltip: {
                    shared: true,
                    intersect: false,
                    y: {
                        formatter: function (value, { seriesIndex, w }) {
                            // Format Pendapatan
                            if (seriesIndex === 0) {
                                let fullValue = value * 1000000;
                                return "Rp " + fullValue.toLocaleString('id-ID');
                            }
                            // Format Pesanan
                            if (seriesIndex === 1) {
                                return value.toFixed(0) + " Pesanan";
                            }
                            return value;
                        }
                    }
                },
                grid: {
                    strokeDashArray: 5,
                    yaxis: { lines: { show: true } }
                }
            };

            var chart = new ApexCharts(document.querySelector("#chartOne"), options);
            chart.render();
        });
    </script>
@endsection