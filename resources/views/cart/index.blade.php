<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Keranjang Belanja - ANImerch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans text-gray-800">

    <nav class="bg-blue-600 text-white shadow-lg sticky top-0 z-50 border-b border-blue-700">
        <div class="w-full px-6 lg:px-12">
            <div class="flex justify-between items-center h-20">

                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-extrabold tracking-wide flex items-center gap-2">
                        <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                        </svg>
                        <span>ANI<span class="text-yellow-400">merch</span></span>
                    </a>
                </div>

                <div class="flex-1 mx-8 lg:mx-16 max-w-5xl hidden md:block">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="query" value="{{ request('query') }}"
                                placeholder="Cari figure impianmu di sini..."
                                class="w-full bg-white text-gray-800 rounded-full py-2.5 px-6 pl-12 focus:outline-none focus:ring-4 focus:ring-yellow-400 transition shadow-inner">
                            <button type="submit"
                                class="absolute left-4 top-3 text-gray-400 hover:text-blue-600 transition">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                                </svg>
                            </button>
                        </div>
                    </form>
                </div>

                <div class="flex items-center gap-8">
                    @auth
                        <a href="/" class="group text-center min-w-[60px]">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 mb-1 group-hover:text-yellow-300 transition" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                                </svg>
                                <span class="text-xs font-bold group-hover:text-yellow-300 transition">Home</span>
                            </div>
                        </a>

                        <a href="{{ route('history') }}" class="group text-center min-w-[60px]">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 mb-1 group-hover:text-yellow-300 transition" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs font-bold group-hover:text-yellow-300 transition">Riwayat</span>
                            </div>
                        </a>

                        <a href="{{ route('cart.index') }}" class="group text-center min-w-[60px]">
                            <div class="flex flex-col items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 text-yellow-300 transition"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-xs font-bold text-yellow-300 transition">Keranjang</span>
                            </div>
                        </a>

                        <div class="relative ml-4" x-data="{ open: false }" @click.outside="open = false">
                            <button @click="open = !open"
                                class="flex items-center gap-2 border border-blue-400 hover:border-yellow-400 bg-blue-700 hover:bg-blue-800 pl-1.5 pr-4 py-1.5 rounded-full transition shadow-sm h-10">

                                @if (Auth::user()->image)
                                    <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                        class="w-7 h-7 rounded-full object-cover border border-yellow-400 shadow-sm">
                                @else
                                    <div
                                        class="w-7 h-7 bg-yellow-400 rounded-full flex items-center justify-center text-blue-900 font-bold text-xs">
                                        {{ substr(Auth::user()->name, 0, 1) }}
                                    </div>
                                @endif

                                <span class="font-bold text-sm hidden sm:inline-block ml-1">
                                    {{ Str::limit(Auth::user()->name, 10) }}
                                </span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div x-show="open" x-cloak x-transition.opacity
                                class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl overflow-hidden border border-gray-100 z-50">
                                <div class="px-4 py-2 bg-gray-50 border-b text-xs text-gray-500">
                                    Hai, {{ Auth::user()->name }}
                                </div>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">
                                    Dashboard Saya
                                </a>
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-3 text-sm font-bold text-blue-600 bg-blue-50/50 hover:bg-blue-100 transition">
                                        Admin Panel
                                    </a>
                                @endif
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 text-sm font-bold">
                                        Log Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    @else
                    @endauth
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-7xl mx-auto px-4 py-10">
        @if (session('success'))
            <div class="mb-6 bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif


        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2 text-slate-800">
                <span>🛒</span> Keranjang Belanja
            </h2>

            @if ($carts->isEmpty())
                <div class="text-center py-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                    </svg>
                    <h2 class="text-2xl font-bold text-gray-400">Keranjang Kosong :(</h2>
                    <p class="text-gray-500 mt-2">Sepertinya kamu belum menambahkan figure apapun.</p>
                    <a href="/"
                        class="mt-6 inline-block bg-blue-600 text-white font-bold py-2 px-6 rounded-full hover:bg-blue-700 transition">
                        Ayo Belanja Sekarang!
                    </a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase border-b-2 border-gray-200">
                                <th class="py-4 px-4">Produk</th>
                                <th class="py-4 px-4">Harga</th>
                                <th class="py-4 px-4">Jumlah</th>
                                <th class="py-4 px-4">Total</th>
                                <th class="py-4 px-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php $grandTotal = 0; @endphp
                            @foreach ($carts as $cart)
                                <tr class="border-b hover:bg-gray-50 transition">
                                    <td class="py-4 px-4 flex items-center gap-4">
                                        @if ($cart->product->image)
                                            <img src="{{ asset('storage/' . $cart->product->image) }}"
                                                alt="{{ $cart->product->name }}"
                                                class="w-16 h-16 object-cover rounded border">
                                        @else
                                            <div
                                                class="w-16 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-400">
                                                No Img
                                            </div>
                                        @endif
                                        <div>
                                            <span
                                                class="font-bold block text-gray-800">{{ $cart->product->name }}</span>
                                            <span class="text-xs text-gray-500">Stok:
                                                {{ $cart->product->stock }}</span>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4">Rp {{ number_format($cart->product->price) }}</td>
                                    <td class="py-4 px-4">
                                        <div class="flex items-center gap-3">
                                            <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="decrease">
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full text-gray-700 font-bold hover:bg-gray-300 transition disabled:opacity-40 disabled:cursor-not-allowed"
                                                    {{ $cart->quantity <= 1 ? 'disabled' : '' }} title="Kurangi">
                                                    -
                                                </button>
                                            </form>

                                            <span class="font-bold text-gray-800 w-4 text-center">
                                                {{ $cart->quantity }}
                                            </span>

                                            <form action="{{ route('cart.update', $cart->id) }}" method="POST">
                                                @csrf
                                                @method('PATCH')
                                                <input type="hidden" name="action" value="increase">
                                                <button type="submit"
                                                    class="w-8 h-8 flex items-center justify-center bg-gray-100 rounded-full text-gray-700 font-bold hover:bg-gray-300 transition disabled:opacity-40 disabled:cursor-not-allowed"
                                                    {{ $cart->quantity >= $cart->product->stock ? 'disabled' : '' }}
                                                    title="Tambah">
                                                    +
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                    <td class="py-4 px-4 font-bold text-blue-600">
                                        Rp {{ number_format($cart->product->price * $cart->quantity) }}
                                    </td>
                                    <td class="py-4 px-4 text-center">
                                        <form action="{{ route('cart.destroy', $cart->id) }}" method="POST">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="text-red-500 hover:text-white hover:bg-red-500 p-2 rounded transition"
                                                title="Hapus Barang">
                                                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                                </svg>
                                            </button>
                                        </form>
                                    </td>
                                </tr>
                                @php $grandTotal += ($cart->product->price * $cart->quantity); @endphp
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-8 flex flex-col md:flex-row justify-end items-center gap-6 border-t pt-6">
                    <div class="text-right">
                        <p class="text-gray-500 text-sm">Total Pembayaran Barang:</p>
                        <p class="text-3xl font-bold text-red-600">Rp {{ number_format($grandTotal) }}</p>
                    </div>

                    <a href="{{ route('checkout.page') }}"
                        class="bg-orange-500 text-white font-bold py-3 px-10 rounded-lg hover:bg-orange-600 shadow-lg transition transform hover:scale-105 flex items-center gap-2">
                        <span>Checkout Semua</span>
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M14 5l7 7m0 0l-7 7m7-7H3" />
                        </svg>
                    </a>
                </div>
            @endif
        </div>
    </div>

</body>

</html>
