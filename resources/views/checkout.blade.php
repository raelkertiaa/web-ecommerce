<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout Pengiriman - ANImerch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>

<body class="bg-gray-50 font-sans text-gray-800">

    <nav class="bg-blue-600 text-white p-4 shadow mb-8">
        <div class="max-w-7xl mx-auto flex items-center gap-4">
            <a href="/" class="hover:text-yellow-300">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
            </a>
            <h1 class="text-xl font-bold">Pengiriman & Pembayaran</h1>
        </div>
    </nav>

    <div class="max-w-6xl mx-auto px-4 pb-20">
        <form action="{{ route('checkout.process') }}" method="POST" class="flex flex-col lg:flex-row gap-8">
            @csrf

            <input type="hidden" name="is_cart" value="{{ $isCart ? 'true' : 'false' }}">
            @if (!$isCart)
                <input type="hidden" name="product_id" value="{{ $items[0]->product->id }}">
                <input type="hidden" name="quantity" value="{{ $items[0]->quantity }}">
            @endif

            <div class="w-full lg:w-2/3 space-y-6">
                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">📍 Alamat Pengiriman</h2>
                    <div class="space-y-4">
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Penerima</label>
                            <input type="text" name="recipient_name" value="{{ Auth::user()->name }}" required
                                class="w-full bg-white border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500 transition"
                                placeholder="Masukkan nama penerima paket">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-1">Alamat Lengkap</label>
                            <textarea name="address" required rows="3"
                                class="w-full border border-gray-300 rounded-lg p-3 focus:ring-2 focus:ring-blue-500"
                                placeholder="Alamat lengkap..."></textarea>
                        </div>
                    </div>
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">🚚 Jasa Pengiriman</h2>
                    <select name="courier" id="courier" onchange="calculateTotal()"
                        class="w-full border border-gray-300 rounded-lg p-3 cursor-pointer bg-white">
                        <option value="" data-cost="0">-- Pilih Kurir --</option>
                        <option value="JNE Regular" data-cost="12000">JNE Regular - Rp 12.000</option>
                        <option value="JNE YES" data-cost="24000">JNE YES - Rp 24.000</option>
                        <option value="J&T Express" data-cost="15000">J&T Express - Rp 15.000</option>
                        <option value="SiCepat Halu" data-cost="10000">SiCepat Halu - Rp 10.000</option>
                    </select>
                    <input type="hidden" name="shipping_cost" id="shipping_cost" value="0">
                </div>

                <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                    <h2 class="text-lg font-bold mb-4 flex items-center gap-2">📦 Daftar Barang</h2>
                    <div class="divide-y divide-gray-100">
                        @foreach ($items as $item)
                            <div class="flex items-center gap-4 py-3">

                                <div class="h-16 w-16 flex-shrink-0 overflow-hidden rounded-md border border-gray-200">
                                    @if ($item->product->image)
                                        <img src="{{ asset('storage/' . $item->product->image) }}"
                                            alt="{{ $item->product->name }}"
                                            class="h-full w-full object-cover object-center">
                                    @else
                                        <div
                                            class="h-full w-full bg-gray-100 flex items-center justify-center text-xs text-gray-400">
                                            No Img</div>
                                    @endif
                                </div>

                                <div class="flex-1">
                                    <h3 class="font-bold text-gray-800">{{ $item->product->name }}</h3>
                                    <p class="text-sm text-gray-500">{{ $item->quantity }} x Rp
                                        {{ number_format($item->product->price) }}</p>
                                </div>
                                <div class="font-bold text-gray-800">Rp
                                    {{ number_format($item->product->price * $item->quantity) }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <div class="w-full lg:w-1/3">
                <div class="bg-white p-6 rounded-lg shadow-lg border border-gray-200 sticky top-24">
                    <h2 class="text-lg font-bold mb-6 border-b pb-2">Rincian Pembayaran</h2>

                    <div class="space-y-3 text-sm text-gray-600 mb-6">
                        <div class="flex justify-between">
                            <span>Total Harga Barang</span>
                            <span>Rp {{ number_format($subtotal) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Pengiriman</span>
                            <span id="display-shipping" class="font-medium">Rp 0</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Biaya Admin</span>
                            <span>Rp 1.000</span>
                        </div>
                        <div class="flex justify-between text-orange-600">
                            <span>PPN (11%)</span>
                            <span id="display-tax">Rp {{ number_format($subtotal * 0.11) }}</span>
                        </div>
                        <div class="flex justify-between">
                            <span>Asuransi Pengiriman</span>
                            <span>Rp 2.500</span>
                        </div>
                    </div>

                    <div class="border-t pt-4 mb-6">
                        <div class="flex justify-between items-center">
                            <span class="font-bold text-lg text-gray-800">Total Tagihan</span>
                            <span id="display-total" class="font-bold text-xl text-orange-600">
                                Rp {{ number_format($subtotal + 1000 + $subtotal * 0.11 + 2500) }}
                            </span>
                        </div>
                    </div>

                    <button type="submit"
                        class="w-full bg-orange-500 text-white font-bold py-3.5 rounded-lg hover:bg-orange-600 transition shadow-md">
                        🛡️ Buat Pesanan
                    </button>
                </div>
            </div>
        </form>
    </div>

    <script>
        const subtotal = {{ $subtotal }};
        const adminFee = 1000;
        const insuranceFee = 2500;
        const taxRate = 0.11; // 11%

        function calculateTotal() {
            // 1. Ambil Ongkir
            const courierSelect = document.getElementById('courier');
            const selectedOption = courierSelect.options[courierSelect.selectedIndex];
            const shippingCost = parseInt(selectedOption.getAttribute('data-cost')) || 0;

            // 2. Hitung PPN (11% dari harga barang)
            const taxFee = Math.round(subtotal * taxRate);

            // 3. Update Input Hidden
            document.getElementById('shipping_cost').value = shippingCost;

            // 4. Update Tampilan Ongkir & Pajak
            document.getElementById('display-shipping').innerText = 'Rp ' + shippingCost.toLocaleString('id-ID');
            document.getElementById('display-tax').innerText = 'Rp ' + taxFee.toLocaleString('id-ID');

            // 5. Hitung Grand Total (Semua angka sudah bulat)
            const grandTotal = subtotal + shippingCost + adminFee + insuranceFee + taxFee;

            // 6. Update Total Tagihan
            document.getElementById('display-total').innerText = 'Rp ' + grandTotal.toLocaleString('id-ID');
        }
    </script>

</body>

</html>
