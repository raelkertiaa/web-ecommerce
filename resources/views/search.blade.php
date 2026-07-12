<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Hasil Pencarian: {{ $query }} - Toko CPZ</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-100 font-sans text-gray-800">

    <nav class="bg-blue-600 text-white shadow-lg sticky top-0 z-50">
        <div class="w-full px-6 lg:px-12">
            <div class="flex justify-between items-center h-20">

                <div class="flex-shrink-0">
                    <a href="/" class="text-2xl font-extrabold tracking-wide">
                        TOKO <span class="text-yellow-400">CPZ</span>
                    </a>
                </div>

                <div class="flex-1 mx-8 lg:mx-16 max-w-5xl hidden md:block">
                    <form action="{{ route('search') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="query" value="{{ $query }}"
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
                                <svg xmlns="http://www.w3.org/2000/svg"
                                    class="h-6 w-6 mb-1 group-hover:text-yellow-300 transition" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
                                </svg>
                                <span class="text-xs font-bold group-hover:text-yellow-300 transition">Keranjang</span>
                            </div>
                        </a>

                        <div class="relative group ml-4">
                            <button
                                class="flex items-center gap-2 border border-blue-400 hover:border-yellow-400 bg-blue-700 hover:bg-blue-800 px-4 py-2 rounded-full transition shadow-sm h-10">
                                <div
                                    class="w-6 h-6 bg-yellow-400 rounded-full flex items-center justify-center text-blue-900 font-bold text-xs">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <span
                                    class="font-bold text-sm hidden sm:inline-block">{{ Str::limit(Auth::user()->name, 10) }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>

                            <div class="absolute right-0 top-full w-48 pt-2 hidden group-hover:block z-50">
                                <div class="bg-white rounded-lg shadow-xl overflow-hidden border border-gray-100">
                                    <div class="px-4 py-2 bg-gray-50 border-b text-xs text-gray-500">
                                        Hai, {{ Auth::user()->name }}
                                    </div>
                                    <a href="{{ url('/dashboard') }}"
                                        class="block px-4 py-3 text-gray-800 hover:bg-gray-100 text-sm">Dashboard</a>
                                    <div class="border-t border-gray-100"></div>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="block w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 text-sm font-bold">Log
                                            Out</button>
                                    </form>
                                </div>
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

    <div class="max-w-7xl mx-auto px-4 py-10">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">
            Hasil Pencarian: "<span class="text-blue-600">{{ $query }}</span>"
        </h2>

        @if ($products->isEmpty())
            <div class="bg-white p-10 rounded-lg shadow text-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <h3 class="text-xl font-bold text-gray-500">Produk tidak ditemukan</h3>
                <p class="text-gray-400 mt-2">Coba kata kunci lain seperti "Gundam" atau "Luffy"</p>
                <a href="/"
                    class="mt-6 inline-block bg-blue-600 text-white px-6 py-2 rounded-full hover:bg-blue-700 transition">Kembali
                    ke Home</a>
            </div>
        @else
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($products as $product)
                    <div
                        class="bg-white rounded-lg shadow-md overflow-hidden hover:shadow-xl transition-shadow duration-300">
                        <a href="{{ route('product.show', $product->id) }}">
                            <img src="{{ $product->image }}" alt="{{ $product->name }}"
                                class="w-full h-48 object-cover">
                            <div class="p-4">
                                <h3 class="font-bold text-lg mb-1 truncate">{{ $product->name }}</h3>
                                <p class="text-orange-500 font-bold">Rp {{ number_format($product->price) }}</p>
                                <div class="flex items-center gap-1 mt-2 text-xs text-gray-500">
                                    <span>⭐ {{ number_format($product->reviews->avg('rating'), 1) }}</span>
                                    <span>({{ $product->reviews->count() }})</span>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

</body>

</html>
