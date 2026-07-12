<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>TOKO ANImerch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>

    <style>
        [x-cloak] {
            display: none !important;
        }

        /* CSS Manual untuk Background agar PASTI muncul */
        .bg-pattern {
            background-color: #ffffff;
            /* Membuat titik-titik abu-abu (Slate-400) */
            background-image: radial-gradient(#94a3b8 1.5px, transparent 1.5px);
            /* Jarak antar titik */
            background-size: 24px 24px;
            /* Transparansi agar tidak terlalu mencolok */
            opacity: 0.6;
        }
    </style>
</head>

<body class="font-sans antialiased text-slate-800 relative selection:bg-blue-500 selection:text-white">

    <div class="fixed inset-0 -z-20 h-full w-full bg-pattern"></div>

    <div class="fixed inset-0 -z-10 h-full w-full"
        style="background: linear-gradient(to bottom, rgba(239, 246, 255, 0.9), rgba(255, 255, 255, 0.1));">
    </div>

    <div class="relative z-10">

        <nav class="bg-blue-600 text-white shadow-lg sticky top-0 z-50 border-b border-blue-700/50">
            <div class="w-full px-6 lg:px-12">
                <div class="flex justify-between items-center h-20">

                    <div class="flex-shrink-0">
                        <a href="/" class="text-2xl font-extrabold tracking-wide flex items-center gap-2">
                            <svg class="w-8 h-8 text-yellow-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            <span>ANI<span class="text-yellow-400">merch</span></span>
                        </a>
                    </div>

                    <div class="flex-1 mx-8 lg:mx-16 max-w-5xl hidden md:block">
                        <form action="{{ route('home') }}" method="GET">
                            <div class="relative">
                                <input type="text" name="search" value="{{ request('search') }}"
                                    placeholder="Cari figure impianmu di sini..."
                                    class="w-full bg-white text-gray-800 rounded-full py-2.5 px-6 pl-12 focus:outline-none focus:ring-4 focus:ring-yellow-400 transition shadow-inner border-0">

                                @if (request('category'))
                                    <input type="hidden" name="category" value="{{ request('category') }}">
                                @endif

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
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-6 w-6 mb-1 group-hover:text-yellow-300 transition" fill="none"
                                        viewBox="0 0 24 24" stroke="currentColor">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                    </svg>
                                    <span class="text-xs font-bold group-hover:text-yellow-300 transition">Keranjang</span>
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
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                        class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                            <div class="flex items-center gap-4">
                                <a href="{{ route('login') }}"
                                    class="font-bold hover:text-yellow-300 transition text-sm">Masuk</a>
                                <div class="h-6 w-px bg-blue-400"></div>
                                <a href="{{ route('register') }}"
                                    class="bg-yellow-400 text-blue-900 font-bold px-5 py-2 rounded-full hover:bg-yellow-300 transition shadow-md text-sm">Daftar</a>
                            </div>
                        @endauth
                    </div>
                </div>
            </div>
        </nav>

        <div class="max-w-7xl mx-auto py-8 px-4">
            <h2 class="text-2xl font-bold mb-4 text-slate-800">Rekomendasi Sultan</h2>

            @if ($products->isNotEmpty())
                <div class="swiper mySwiper rounded-2xl overflow-hidden h-64 md:h-96 shadow-2xl border-4 border-white">
                    <div class="swiper-wrapper">
                        @foreach ($products->where('stock', '>', 0)->take(3) as $product)
                            <div class="swiper-slide relative group cursor-pointer">
                                <a href="{{ route('product.show', $product->id) }}" class="block w-full h-full">

                                    <img src="{{ asset('storage/' . $product->image) }}"
                                        class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105">

                                    <div
                                        class="absolute inset-0 bg-gradient-to-t from-slate-900/90 via-slate-900/30 to-transparent">
                                    </div>

                                    <div
                                        class="absolute bottom-0 left-0 p-8 w-full transform transition-transform duration-500 group-hover:-translate-y-2">
                                        <h3 class="text-3xl font-extrabold text-white drop-shadow-md">
                                            {{ $product->name }}</h3>

                                        <div class="flex items-center gap-4 mt-2">
                                            <p class="text-yellow-400 font-bold text-2xl drop-shadow-sm">
                                                Rp {{ number_format($product->price, 0, ',', '.') }}
                                            </p>

                                            <span
                                                class="opacity-0 group-hover:opacity-100 transition-opacity duration-300 bg-orange-500 text-white text-sm font-bold py-1 px-4 rounded-full shadow-lg">
                                                Lihat Detail &rarr;
                                            </span>
                                        </div>
                                    </div>

                                </a>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                    <div class="swiper-button-next"></div>
                    <div class="swiper-button-prev"></div>
                </div>
            @else
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200 text-center text-gray-500">
                    Belum ada produk unggulan.
                </div>
            @endif
        </div>

        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-4 mb-12">

            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h2 class="text-2xl font-bold text-slate-800 flex items-center gap-2">
                    <span class="bg-blue-600 w-2 h-8 rounded-full"></span>
                    Katalog Produk
                </h2>

                <div class="relative z-30" x-data="{ open: false }" @click.outside="open = false">

                    <button @click="open = !open"
                        class="flex items-center gap-3 px-6 py-2.5 bg-white border border-gray-200 rounded-full shadow-lg shadow-blue-500/10 text-gray-700 font-bold hover:border-blue-500 hover:text-blue-600 transition w-64 justify-between">

                        <span class="flex items-center gap-2">
                            @if (request('category') == 'fashion')
                                <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                                </svg> Fashion
                            @elseif(request('category') == 'elektronik')
                                <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                    </path>
                                </svg> Elektronik
                            @elseif(request('category') == 'merch')
                                <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                                </svg> Merch Anime
                            @else
                                <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg> Semua Kategori
                            @endif
                        </span>

                        <svg class="h-4 w-4 transition-transform duration-200" :class="open ? 'rotate-180' : ''"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    <div x-show="open" x-cloak x-transition.opacity
                        class="absolute right-0 md:left-0 top-full mt-2 w-64 bg-white rounded-xl shadow-xl border border-gray-100 overflow-hidden z-50">
                        <a href="{{ route('home') }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-gray-50 hover:text-blue-600 border-b border-gray-50 {{ !request('category') ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700' }}">
                            <svg class="w-5 h-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                </path>
                            </svg> Semua Produk
                        </a>
                        <a href="{{ route('home', ['category' => 'fashion']) }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-purple-50 hover:text-purple-600 border-b border-gray-50 {{ request('category') == 'fashion' ? 'bg-purple-50 text-purple-600 font-bold' : 'text-gray-700' }}">
                            <svg class="w-5 h-5 text-purple-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"></path>
                            </svg> Fashion & Baju
                        </a>
                        <a href="{{ route('home', ['category' => 'elektronik']) }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-blue-50 hover:text-blue-600 border-b border-gray-50 {{ request('category') == 'elektronik' ? 'bg-blue-50 text-blue-600 font-bold' : 'text-gray-700' }}">
                            <svg class="w-5 h-5 text-blue-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 18h.01M8 21h8a2 2 0 002-2V5a2 2 0 00-2-2H8a2 2 0 00-2 2v14a2 2 0 002 2z">
                                </path>
                            </svg> Elektronik
                        </a>
                        <a href="{{ route('home', ['category' => 'merch']) }}"
                            class="flex items-center gap-3 px-4 py-3 text-sm hover:bg-pink-50 hover:text-pink-600 {{ request('category') == 'merch' ? 'bg-pink-50 text-pink-600 font-bold' : 'text-gray-700' }}">
                            <svg class="w-5 h-5 text-pink-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4"></path>
                            </svg> Merchandise Anime
                        </a>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @forelse ($products as $product)
                    <div
                        class="bg-white rounded-xl shadow-lg shadow-blue-900/5 overflow-hidden hover:shadow-xl hover:shadow-blue-500/20 transition-all duration-300 border border-gray-100 flex flex-col h-full transform hover:-translate-y-1">

                        <div class="h-64 bg-gray-100 w-full overflow-hidden relative group shrink-0">
                            @if ($product->image)
                                <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                                    class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500 
                                    {{ $product->stock <= 0 ? 'grayscale opacity-60' : '' }}">
                            @else
                                <div class="flex items-center justify-center h-full text-gray-400">No Image</div>
                            @endif

                            @if ($product->stock <= 0)
                                <div
                                    class="absolute inset-0 flex items-center justify-center bg-black/40 z-10 backdrop-blur-[1px]">
                                    <span
                                        class="bg-red-600 text-white text-sm font-bold px-4 py-1.5 rounded-full shadow-lg border-2 border-white transform -rotate-3">
                                        STOK HABIS
                                    </span>
                                </div>
                            @endif
                        </div>

                        <div class="p-5 flex flex-col flex-1">
                            @if ($product->category)
                                <span
                                    class="text-[10px] uppercase font-bold text-blue-600 tracking-wider mb-2 block bg-blue-50 w-fit px-2 py-1 rounded-md">
                                    {{ $product->category }}
                                </span>
                            @endif

                            <h3 class="font-bold text-slate-800 text-lg truncate mb-1" title="{{ $product->name }}">
                                {{ $product->name }}
                            </h3>
                            <p class="text-sm text-slate-500 mb-3 truncate">{{ $product->description }}</p>

                            <div class="mt-auto pt-3 border-t border-dashed border-gray-200">
                                <div class="flex justify-between items-center mb-3">
                                    <span class="text-slate-400 text-xs font-semibold">HARGA</span>
                                    <span
                                        class="text-red-600 font-extrabold text-lg {{ $product->stock <= 0 ? 'text-gray-400' : '' }}">
                                        Rp {{ number_format($product->price, 0, ',', '.') }}
                                    </span>
                                </div>

                                <a href="{{ route('product.show', $product->id) }}"
                                    class="block text-center w-full bg-orange-500 text-white font-bold py-2.5 px-4 rounded-lg hover:bg-orange-600 transition shadow-md shadow-orange-500/20 transform hover:-translate-y-0.5">
                                    Detail Barang
                                </a>
                            </div>
                        </div>
                    </div>
                @empty
                    <div
                        class="col-span-full py-16 text-center bg-white/50 backdrop-blur-sm rounded-2xl border border-dashed border-gray-300">
                        <div
                            class="inline-flex items-center justify-center w-20 h-20 rounded-full bg-blue-50 text-blue-500 mb-6">
                            <svg class="w-10 h-10" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800 mb-2">Produk tidak ditemukan</h3>
                        <p class="text-gray-500">Coba kata kunci lain atau pilih kategori yang berbeda.</p>

                        @if (request('category') || request('search'))
                            <a href="{{ route('home') }}"
                                class="mt-6 inline-block text-blue-600 font-bold hover:underline">
                                Reset Filter & Pencarian
                            </a>
                        @endif
                    </div>
                @endforelse
            </div>
        </div>

        <footer class="bg-slate-800 text-white py-12 mt-12 border-t-4 border-yellow-400 relative z-20">
            <div class="max-w-7xl mx-auto px-4 text-center">
                <h3 class="text-2xl font-extrabold mb-2 tracking-wide">ANI<span class="text-yellow-400">merch</span>
                </h3>
                <p class="text-slate-400 text-sm">&copy; 2024 Kyou Clone Project. Tugas Teknik Informatika.</p>
            </div>
        </footer>
    </div>

    <script>
        var swiper = new Swiper(".mySwiper", {
            loop: true,
            autoplay: {
                delay: 3000
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev"
            },
        });
    </script>

</body>

</html>
