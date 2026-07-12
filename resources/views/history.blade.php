<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Belanja - ANImerch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        /* Efek Hover Bintang */
        .rate:not(:checked)>input {
            position: absolute;
            top: -9999px;
        }

        .rate:not(:checked)>label {
            float: right;
            width: 1em;
            overflow: hidden;
            white-space: nowrap;
            cursor: pointer;
            font-size: 30px;
            color: #ccc;
        }

        .rate:not(:checked)>label:before {
            content: '★ ';
        }

        .rate>input:checked~label {
            color: #ffc700;
        }

        .rate:not(:checked)>label:hover,
        .rate:not(:checked)>label:hover~label {
            color: #deb217;
        }

        .rate>input:checked+label:hover,
        .rate>input:checked+label:hover~label,
        .rate>input:checked~label:hover,
        .rate>input:checked~label:hover~label,
        .rate>label:hover~input:checked~label {
            color: #c59b08;
        }

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
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mb-1 text-yellow-300 transition"
                                    fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-xs font-bold text-yellow-300 transition">Riwayat</span>
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
                                <span
                                    class="font-bold text-sm hidden sm:inline-block ml-1">{{ Str::limit(Auth::user()->name, 10) }}</span>
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 transition-transform duration-200"
                                    :class="open ? 'rotate-180' : ''" fill="none" viewBox="0 0 24 24"
                                    stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </button>
                            <div x-show="open" x-cloak x-transition.opacity
                                class="absolute right-0 top-full mt-2 w-48 bg-white rounded-lg shadow-xl overflow-hidden border border-gray-100 z-50">
                                <div class="px-4 py-2 bg-gray-50 border-b text-xs text-gray-500">Hai,
                                    {{ Auth::user()->name }}</div>
                                <a href="{{ route('dashboard') }}"
                                    class="block px-4 py-3 text-sm text-gray-700 hover:bg-blue-50 hover:text-blue-600 transition">Dashboard
                                    Saya</a>
                                @if (Auth::user()->role === 'admin')
                                    <a href="{{ route('admin.dashboard') }}"
                                        class="block px-4 py-3 text-sm font-bold text-blue-600 bg-blue-50/50 hover:bg-blue-100 transition">Admin
                                        Panel</a>
                                @endif
                                <div class="border-t border-gray-100"></div>
                                <form method="POST" action="{{ route('logout') }}">
                                    @csrf
                                    <button type="submit"
                                        class="block w-full text-left px-4 py-3 text-red-600 hover:bg-red-50 text-sm font-bold">Log
                                        Out</button>
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
                <strong class="font-bold">Berhasil!</strong> <span
                    class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif
        @if (session('error'))
            <div class="mb-6 bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <strong class="font-bold">Gagal!</strong> <span class="block sm:inline">{{ session('error') }}</span>
            </div>
        @endif

        <div class="bg-white rounded-lg shadow-lg overflow-hidden p-6">
            <h2 class="text-2xl font-bold mb-6 flex items-center gap-2 text-slate-800"><span>📦</span> Riwayat
                Transaksi</h2>

            @if ($orders->isEmpty())
                <div class="text-center py-20">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-24 w-24 mx-auto text-gray-300 mb-4"
                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    <p class="text-gray-500 text-lg">Kamu belum pernah belanja, nih.</p>
                    <a href="/" class="text-blue-600 font-bold mt-2 inline-block hover:underline">Mulai Belanja
                        Sekarang &raquo;</a>
                </div>
            @else
                <div class="overflow-x-auto">
                    <table class="w-full text-left border-collapse">
                        <thead>
                            <tr class="bg-gray-50 text-gray-600 text-sm uppercase border-b-2 border-gray-200">
                                <th class="p-4">Produk</th>
                                <th class="p-4">Tanggal</th>
                                <th class="p-4">Total Tagihan</th>
                                <th class="p-4">Status Pengiriman</th>
                                <th class="p-4">Sisa Waktu</th>
                                <th class="p-4 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @foreach ($orders as $order)
                                <tr
                                    class="hover:bg-gray-50 transition {{ $order->delivery_status == 'cancelled' ? 'bg-red-50 hover:bg-red-50 opacity-75' : '' }}">
                                    <td class="p-4">
                                        <ul class="space-y-1">
                                            @foreach ($order->orderItems as $item)
                                                <li class="flex items-center gap-2 text-sm font-medium">
                                                    <span class="text-blue-600">•</span>
                                                    {{ $item->product->name }}
                                                    <span
                                                        class="text-gray-400 text-xs">(x{{ $item->quantity }})</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </td>
                                    <td class="p-4 text-gray-500 text-sm">
                                        {{ $order->created_at->format('d M Y H:i') }}</td>
                                    <td class="p-4 font-bold text-gray-800">Rp
                                        {{ number_format($order->total_price) }}</td>
                                    <td class="p-4">
                                        @if ($order->delivery_status == 'cancelled')
                                            <span
                                                class="bg-red-600 text-white text-xs px-3 py-1 rounded-full font-bold shadow-sm">❌
                                                DIBATALKAN</span>
                                        @elseif ($order->status == 'Unpaid')
                                            <span
                                                class="bg-red-100 text-red-800 text-xs px-3 py-1 rounded-full font-bold border border-red-200">BELUM
                                                BAYAR</span>
                                        @elseif ($order->delivery_status == 'processing')
                                            <span
                                                class="bg-yellow-100 text-yellow-800 text-xs px-3 py-1 rounded-full font-bold border border-yellow-200">📦
                                                DIKEMAS</span>
                                        @elseif ($order->delivery_status == 'shipping')
                                            <span
                                                class="bg-blue-100 text-blue-800 text-xs px-3 py-1 rounded-full font-bold border border-blue-200">🚚
                                                DIKIRIM</span>
                                        @elseif ($order->delivery_status == 'completed')
                                            <span
                                                class="bg-green-100 text-green-800 text-xs px-3 py-1 rounded-full font-bold border border-green-200">✅
                                                SELESAI</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-red-600 font-bold text-sm">
                                        @if ($order->delivery_status == 'cancelled')
                                            <span class="text-gray-400">-</span>
                                        @elseif ($order->status == 'Unpaid')
                                            <span class="countdown-timer bg-red-50 px-2 py-1 rounded"
                                                data-expire="{{ $order->created_at->addMinute()->timestamp * 1000 }}">⏳
                                                Menghitung...</span>
                                        @else
                                            <span class="text-gray-400">-</span>
                                        @endif
                                    </td>
                                    <td class="p-4 text-center">

                                        @if ($order->delivery_status == 'cancelled')
                                            <button disabled
                                                class="bg-gray-300 text-gray-500 text-xs font-bold px-4 py-2 rounded cursor-not-allowed">
                                                Pesanan Batal
                                            </button>
                                        @elseif ($order->status == 'Unpaid')
                                            <button
                                                onclick="payNow('{{ $order->snap_token }}', '{{ $order->id }}')"
                                                class="bg-orange-500 hover:bg-orange-600 text-white text-sm font-bold px-4 py-2 rounded shadow transition transform hover:scale-105">Bayar
                                                Sekarang</button>
                                        @elseif ($order->delivery_status == 'processing')
                                            <div class="flex flex-col items-center gap-1">
                                                <span class="text-xs text-gray-500">Menunggu Kurir...</span>
                                            </div>
                                        @elseif ($order->delivery_status == 'shipping')
                                            <form action="{{ route('order.receive', $order->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-blue-600 hover:bg-blue-700 text-white text-sm font-bold px-4 py-2 rounded shadow transition transform hover:scale-105 flex items-center gap-1 mx-auto">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                        fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M5 13l4 4L19 7" />
                                                    </svg>
                                                    Terima Pesanan
                                                </button>
                                            </form>
                                        @elseif ($order->delivery_status == 'completed')
                                            <div class="flex flex-col items-center gap-2">
                                                <span
                                                    class="text-green-600 font-bold text-sm flex justify-center items-center gap-1">
                                                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5"
                                                        viewBox="0 0 20 20" fill="currentColor">
                                                        <path fill-rule="evenodd"
                                                            d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                                            clip-rule="evenodd" />
                                                    </svg>
                                                    Selesai
                                                </span>
                                                @php
                                                    $productId = $order->orderItems->first()->product->id;
                                                    $hasReviewed = \App\Models\Review::where('user_id', Auth::id())
                                                        ->where('product_id', $productId)
                                                        ->where('order_id', $order->id)
                                                        ->exists();
                                                @endphp
                                                @if ($hasReviewed)
                                                    <button disabled
                                                        class="text-xs bg-gray-300 text-gray-500 px-3 py-1 rounded font-bold cursor-not-allowed flex items-center gap-1">
                                                        <span>✓</span> Sudah Dinilai
                                                    </button>
                                                @else
                                                    <button
                                                        onclick="openReviewModal('{{ $productId }}', '{{ $order->orderItems->first()->product->name }}', '{{ $order->id }}')"
                                                        class="text-xs bg-yellow-400 hover:bg-yellow-500 text-blue-900 px-3 py-1 rounded font-bold shadow transition flex items-center gap-1">
                                                        <span>⭐</span> Beri Nilai
                                                    </button>
                                                @endif
                                            </div>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @endif
        </div>
    </div>

    <div id="reviewModal" class="fixed inset-0 bg-black bg-opacity-50 hidden z-50 justify-center items-center">
        <div class="bg-white rounded-lg shadow-xl w-96 p-6 relative">
            <button onclick="closeReviewModal()"
                class="absolute top-3 right-3 text-gray-400 hover:text-gray-600 text-xl font-bold">✖</button>
            <h2 class="text-xl font-bold mb-2 text-gray-800">Beri Penilaian</h2>
            <p class="text-sm text-gray-500 mb-4">Produk: <span id="modalProductName"
                    class="font-bold text-blue-600"></span></p>
            <form action="{{ route('review.store') }}" method="POST">
                @csrf
                <input type="hidden" name="product_id" id="modalProductId">
                <input type="hidden" name="order_id" id="modalOrderId">
                <div class="flex flex-row-reverse justify-center gap-1 mb-4 rate">
                    <input type="radio" id="star5" name="rating" value="5" /><label for="star5"
                        title="5 stars">5 stars</label>
                    <input type="radio" id="star4" name="rating" value="4" /><label for="star4"
                        title="4 stars">4 stars</label>
                    <input type="radio" id="star3" name="rating" value="3" /><label for="star3"
                        title="3 stars">3 stars</label>
                    <input type="radio" id="star2" name="rating" value="2" /><label for="star2"
                        title="2 stars">2 stars</label>
                    <input type="radio" id="star1" name="rating" value="1" /><label for="star1"
                        title="1 star">1 star</label>
                </div>
                <textarea name="comment" rows="3"
                    class="w-full border rounded p-2 text-sm focus:ring-2 focus:ring-yellow-400 focus:outline-none"
                    placeholder="Tulis ulasanmu di sini..."></textarea>
                <button type="submit"
                    class="w-full bg-blue-600 text-white font-bold py-2 rounded mt-4 hover:bg-blue-700 transition">Kirim
                    Penilaian</button>
            </form>
        </div>
    </div>

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>
    <script type="text/javascript">
        function openReviewModal(productId, productName, orderId) {
            var modal = document.getElementById('reviewModal');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            document.getElementById('modalProductId').value = productId;
            document.getElementById('modalProductName').innerText = productName;
            document.getElementById('modalOrderId').value = orderId;
        }

        function closeReviewModal() {
            var modal = document.getElementById('reviewModal');
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }

        function payNow(snapToken, orderId) {
            window.snap.pay(snapToken, {
                onSuccess: function(result) {
                    window.location.href = '/order/success/' + orderId;
                },
                onPending: function(result) {
                    alert("Menunggu pembayaran!");
                    location.reload();
                },
                onError: function(result) {
                    alert("Pembayaran gagal!");
                    location.reload();
                }
            });
        }
        setInterval(function() {
            var timers = document.querySelectorAll('.countdown-timer');
            var now = new Date().getTime();
            timers.forEach(function(timer) {
                var expireTime = parseInt(timer.getAttribute('data-expire'));
                var distance = expireTime - now;
                if (distance < 0) {
                    timer.innerHTML = "Waktu Habis";
                    timer.classList.add('text-gray-500');
                    location.reload();
                } else {
                    var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                    var seconds = Math.floor((distance % (1000 * 60)) / 1000);
                    timer.innerHTML = "⏳ " + minutes + "m " + seconds + "s";
                }
            });
        }, 1000);
    </script>

</body>

</html>
