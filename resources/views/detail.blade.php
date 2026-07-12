<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ $product->name }} - ANImerch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        [x-cloak] {
            display: none !important;
        }
    </style>
</head>

<body class="bg-gray-50 font-sans antialiased text-slate-800">

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
                    <form action="{{ route('home') }}" method="GET">
                        <div class="relative">
                            <input type="text" name="search" value="{{ request('search') }}"
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

    <div class="max-w-7xl mx-auto px-4 mt-6">
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative" role="alert">
                <strong class="font-bold">Sukses!</strong>
                <span class="block sm:inline">{{ session('success') }}</span>
                <a href="{{ route('cart.index') }}" class="underline font-bold ml-2">Lihat Keranjang &raquo;</a>
            </div>
        @endif
    </div>

    <div class="max-w-7xl mx-auto px-4 py-10">
        <div class="bg-white rounded-lg shadow-lg overflow-hidden">
            <div class="md:flex">

                <div class="md:w-1/2 bg-gray-50 flex justify-center items-center p-6 relative">
                    @if ($product->image)
                        <img src="{{ asset('storage/' . $product->image) }}" alt="{{ $product->name }}"
                            class="w-full h-[700px] object-cover rounded-lg shadow-sm {{ $product->stock <= 0 ? 'grayscale opacity-60' : '' }}">
                    @else
                        <div
                            class="w-[300px] h-[300px] bg-gray-200 flex items-center justify-center text-gray-400 rounded-lg shadow-inner">
                            <div class="text-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto mb-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>No Image</span>
                            </div>
                        </div>
                    @endif

                    @if ($product->stock <= 0)
                        <div class="absolute inset-0 flex items-center justify-center z-10">
                            <span
                                class="bg-red-600 text-white text-3xl font-bold px-8 py-4 rounded-lg shadow-2xl border-4 border-white transform -rotate-12">
                                STOK HABIS
                            </span>
                        </div>
                    @endif
                </div>

                <div class="md:w-1/2 p-8">
                    <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $product->name }}</h1>
                    <div class="text-2xl font-bold text-red-600 mb-6">
                        Rp {{ number_format($product->price, 0, ',', '.') }}
                    </div>

                    <p class="text-gray-600 mb-6 leading-relaxed">
                        {{ $product->description }}
                    </p>

                    <div class="border-t pt-6">
                        <div class="flex justify-between items-center mb-4">
                            <p class="text-sm text-gray-500">Stok Tersedia:</p>
                            <span class="font-bold {{ $product->stock > 0 ? 'text-blue-600' : 'text-red-500' }}">
                                {{ $product->stock > 0 ? $product->stock . ' pcs' : 'Habis' }}
                            </span>
                        </div>

                        <div class="flex items-center gap-4 mb-6">
                            <label class="font-medium text-gray-700">Jumlah:</label>
                            <input type="number" name="quantity" id="main-qty" value="1" min="1"
                                max="{{ $product->stock }}"
                                class="border-2 rounded-lg p-2 w-24 text-center focus:border-blue-500 focus:outline-none {{ $product->stock <= 0 ? 'bg-gray-100 text-gray-400 cursor-not-allowed' : '' }}"
                                onchange="document.getElementById('hidden-qty').value = this.value"
                                {{ $product->stock <= 0 ? 'disabled' : '' }}>
                        </div>

                        @if ($product->stock > 0)
                            <div class="flex flex-col gap-3">
                                @auth
                                    <a href="{{ route('checkout.page', ['product_id' => $product->id, 'quantity' => 1]) }}"
                                        onclick="this.href = this.href.replace(/quantity=\d+/, 'quantity=' + document.getElementById('main-qty').value)"
                                        class="block text-center w-full bg-orange-500 text-white font-bold py-4 rounded-lg hover:bg-orange-600 transition shadow-md hover:shadow-lg transform hover:-translate-y-0.5">
                                        BELI SEKARANG
                                    </a>

                                    <form action="{{ route('cart.add', $product->id) }}" method="POST">
                                        @csrf
                                        <input type="hidden" name="quantity" id="hidden-qty" value="1">
                                        <button type="submit"
                                            class="w-full bg-white border-2 border-blue-600 text-blue-600 font-bold py-4 rounded-lg hover:bg-blue-50 transition">
                                            + Masuk Keranjang
                                        </button>
                                    </form>
                                @else
                                    <a href="{{ route('login') }}"
                                        class="block text-center w-full bg-blue-600 text-white font-bold py-4 rounded-lg hover:bg-blue-700 transition shadow-md">
                                        Login Dulu untuk Membeli
                                    </a>
                                @endauth
                            </div>
                        @else
                            <button disabled
                                class="w-full bg-gray-300 text-gray-500 font-bold py-4 rounded-lg cursor-not-allowed border-2 border-gray-300">
                                Stok Habis - Tunggu Restock Ya!
                            </button>
                        @endif

                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-4 py-8 mb-10">
        <div class="bg-white rounded-lg shadow-lg p-6">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2">
                <span>⭐</span> Ulasan Pembeli
                <span class="text-sm font-normal text-gray-500 bg-gray-100 px-2 py-1 rounded-full">
                    {{ $product->reviews->count() }} Ulasan
                </span>
            </h2>

            @if ($product->reviews->isEmpty())
                <div class="text-center py-8 bg-gray-50 rounded-lg border border-dashed border-gray-300">
                    <p class="text-gray-500 italic">Belum ada ulasan untuk produk ini.</p>
                </div>
            @else
                <div class="flex items-center gap-4 mb-8 bg-yellow-50 p-6 rounded-xl border border-yellow-100">
                    <div class="text-5xl font-bold text-yellow-500">
                        {{ number_format($product->reviews->avg('rating'), 1) }}
                    </div>
                    <div class="text-sm text-gray-600">
                        <div class="flex text-yellow-400 text-xl mb-1">
                            @for ($i = 1; $i <= 5; $i++)
                                <span>{{ $i <= round($product->reviews->avg('rating')) ? '★' : '☆' }}</span>
                            @endfor
                        </div>
                        <span class="font-medium text-gray-700">{{ $product->reviews->count() }}</span> ulasan dari
                        pembeli
                    </div>
                </div>

                <div class="space-y-6">
                    @foreach ($product->reviews as $review)
                        <div class="border-b border-gray-100 pb-6 last:border-0">
                            <div class="flex items-center justify-between mb-3">
                                <div class="flex items-center gap-3">
                                    <div
                                        class="w-10 h-10 bg-blue-100 rounded-full flex items-center justify-center text-blue-600 font-bold text-sm shadow-sm overflow-hidden">
                                        @if ($review->user->image)
                                            <img src="{{ asset('storage/' . $review->user->image) }}"
                                                class="w-full h-full object-cover">
                                        @else
                                            {{ substr($review->user->name, 0, 1) }}
                                        @endif
                                    </div>
                                    <div>
                                        <span
                                            class="font-bold text-sm block text-gray-800">{{ $review->user->name }}</span>
                                        <span
                                            class="text-xs text-gray-400">{{ $review->created_at->format('d M Y') }}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="text-yellow-400 text-sm mb-2">
                                @for ($i = 1; $i <= 5; $i++)
                                    <span>{{ $i <= $review->rating ? '★' : '☆' }}</span>
                                @endfor
                            </div>
                            <p class="text-gray-700 text-sm bg-gray-50 p-3 rounded-lg">{{ $review->comment }}</p>
                        </div>
                    @endforeach
                </div>
            @endif
        </div>
    </div>

</body>

</html>
