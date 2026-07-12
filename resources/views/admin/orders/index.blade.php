@extends('layouts.admin')

@section('title', 'Daftar Pesanan')

@section('content')
    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7.5 xl:pb-1">

        <div class="mb-6 flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between">

            <h4 class="text-xl font-bold text-black">
                Order List
            </h4>

            <div class="flex flex-col gap-2 sm:flex-row sm:items-center">

                <form action="{{ route('admin.orders.index') }}" method="GET"
                    class="flex flex-col gap-2 sm:flex-row sm:items-center">

                    <div class="relative">
                        <button class="absolute top-1/2 left-3 -translate-y-1/2">
                            <svg class="fill-body hover:fill-primary" width="20" height="20" viewBox="0 0 20 20"
                                fill="none">
                                <path fill-rule="evenodd" clip-rule="evenodd"
                                    d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                    fill="#64748B" />
                            </svg>
                        </button>
                        <input type="text" name="search" value="{{ request('search') }}"
                            placeholder="Cari Order ID / Nama..."
                            class="w-full rounded border-[1.5px] border-stroke bg-transparent py-2 pl-10 pr-4 outline-none focus:border-blue-500 active:border-blue-500 sm:w-64">
                    </div>

                    <select name="filter" onchange="this.form.submit()"
                        class="rounded border-[1.5px] border-stroke bg-transparent py-2 px-4 outline-none transition focus:border-blue-500 active:border-blue-500 cursor-pointer">
                        <option value="">Semua Waktu</option>
                        <option value="7" {{ request('filter') == '7' ? 'selected' : '' }}>7 Hari Terakhir</option>
                        <option value="15" {{ request('filter') == '15' ? 'selected' : '' }}>15 Hari Terakhir</option>
                        <option value="30" {{ request('filter') == '30' ? 'selected' : '' }}>30 Hari Terakhir</option>
                    </select>

                </form>

                <a href="{{ route('admin.orders.export', request()->query()) }}"
                    class="inline-flex items-center justify-center gap-2.5 rounded bg-blue-600 py-2 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                    </svg>
                    Export CSV
                </a>

            </div>
        </div>

        <div class="flex flex-col">
            <div class="grid grid-cols-3 rounded-sm bg-gray-100 sm:grid-cols-6 p-2.5">
                <div class="p-2.5 xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Order ID</h5>
                </div>
                <div class="p-2.5 xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Customer</h5>
                </div>
                <div class="p-2.5 text-center xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Total</h5>
                </div>
                <div class="hidden p-2.5 text-center sm:block xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Payment</h5>
                </div>
                <div class="hidden p-2.5 text-center sm:block xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Delivery</h5>
                </div>
                <div class="hidden p-2.5 text-center sm:block xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Action</h5>
                </div>
            </div>

            @foreach ($orders as $order)
                <div class="grid grid-cols-3 border-b border-stroke sm:grid-cols-6 p-2.5 hover:bg-gray-50 transition">

                    <div class="p-2.5 xl:p-5">
                        <p class="font-bold text-black">#{{ $order->id }}</p>
                        <p class="text-xs text-gray-500">{{ $order->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="p-2.5 xl:p-5 flex items-center">
                        <p class="text-black font-medium">{{ $order->user->name ?? 'Guest' }}</p>
                    </div>

                    <div class="flex items-center justify-center p-2.5 xl:p-5">
                        <p class="text-green-600 font-bold">Rp {{ number_format($order->total_price, 0, ',', '.') }}</p>
                    </div>

                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                        <span
                            class="inline-flex rounded px-3 py-1 text-sm font-medium {{ $order->status == 'Paid' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                            {{ $order->status }}
                        </span>
                    </div>

                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                        <form action="{{ route('admin.orders.updateStatus', $order->id) }}" method="POST">
                            @csrf @method('PATCH')
                            <select name="delivery_status" onchange="this.form.submit()"
                                class="text-sm border-none bg-transparent focus:ring-0 cursor-pointer font-bold
                        {{ $order->delivery_status == 'completed' ? 'text-green-600' : 'text-blue-600' }}">
                                <option value="pending" {{ $order->delivery_status == 'pending' ? 'selected' : '' }}>
                                    Pending</option>
                                <option value="processing" {{ $order->delivery_status == 'processing' ? 'selected' : '' }}>
                                    Dikemas</option>
                                <option value="shipping" {{ $order->delivery_status == 'shipping' ? 'selected' : '' }}>
                                    Dikirim</option>
                                <option value="completed" {{ $order->delivery_status == 'completed' ? 'selected' : '' }}>
                                    Selesai</option>
                                <option value="cancelled" {{ $order->delivery_status == 'cancelled' ? 'selected' : '' }}>
                                    Batal</option>
                            </select>
                        </form>
                    </div>

                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                        <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                            onsubmit="return confirm('Hapus?');">
                            @csrf @method('DELETE')
                            <button class="hover:text-red-600">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="p-4">
            {{ $orders->links() }}
        </div>
    </div>
@endsection
