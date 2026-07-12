<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Dashboard User - ANImerch</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="bg-gray-50 font-sans antialiased">

    <nav class="bg-blue-600 text-white shadow-lg sticky top-0 z-50">
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

                <div class="flex items-center gap-4">
                    <span class="text-sm font-medium hidden sm:block">Halo, {{ Auth::user()->name }}</span>
                    <a href="/"
                        class="bg-white/20 hover:bg-white/30 px-4 py-2 rounded-full text-sm font-bold transition">
                        &larr; Belanja
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <div class="max-w-4xl mx-auto py-10 px-4 sm:px-6 lg:px-8">

        <div class="mb-8 text-center md:text-left">
            <h1 class="text-3xl font-bold text-gray-800">Dashboard Saya</h1>
            <p class="text-gray-500 mt-2">Kelola informasi profil kamu.</p>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">

            <div class="md:col-span-1">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-6 text-center">
                    <div class="relative w-32 h-32 mx-auto mb-4">
                        @if (Auth::user()->image)
                            <img src="{{ asset('storage/' . Auth::user()->image) }}"
                                class="w-full h-full object-cover rounded-full border-4 border-blue-50 shadow-md">
                        @else
                            <div
                                class="w-full h-full rounded-full bg-blue-100 flex items-center justify-center text-blue-600 text-4xl font-bold border-4 border-white shadow-md">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                        @endif
                    </div>

                    <h2 class="text-xl font-bold text-gray-800">{{ Auth::user()->name }}</h2>
                    <p class="text-sm text-gray-500 mb-6">{{ Auth::user()->email }}</p>

                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="w-full bg-red-50 text-red-600 font-bold py-2.5 rounded-xl hover:bg-red-100 transition border border-red-100">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>

            <div class="md:col-span-2">
                <div class="bg-white rounded-2xl shadow-sm border border-gray-100 p-8">
                    <h3 class="text-xl font-bold text-gray-800 mb-6 border-b pb-4">Edit Profil</h3>

                    @if (session('success'))
                        <div
                            class="mb-6 bg-green-50 border border-green-200 text-green-700 px-4 py-3 rounded-lg text-sm font-bold">
                            {{ session('success') }}
                        </div>
                    @endif

                    <form action="{{ route('dashboard.update') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Nama Lengkap</label>
                            <input type="text" name="name" value="{{ old('name', Auth::user()->name) }}" required
                                class="w-full rounded-xl border-gray-300 focus:border-blue-500 bg-gray-50 p-3">
                        </div>

                        <div class="mb-6">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Email</label>
                            <input type="email" value="{{ Auth::user()->email }}" disabled
                                class="w-full rounded-xl border-gray-200 bg-gray-100 text-gray-400 p-3 cursor-not-allowed">
                        </div>

                        <div class="mb-8">
                            <label class="block text-sm font-bold text-gray-700 mb-2">Foto Profil</label>
                            <input type="file" name="image" accept="image/*" onchange="previewImage(event)"
                                class="block w-full text-sm text-gray-500 file:mr-4 file:py-2.5 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-bold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" />

                            <div id="preview-box" class="mt-4 hidden">
                                <p class="text-xs text-gray-500 mb-2">Preview:</p>
                                <img id="preview-img"
                                    class="w-16 h-16 rounded-full object-cover border-2 border-blue-500">
                            </div>
                            @error('image')
                                <p class="text-red-500 text-xs font-bold mt-2">{{ $message }}</p>
                            @enderror
                        </div>

                        <button type="submit"
                            class="w-full bg-blue-600 text-white font-bold py-3 px-6 rounded-xl hover:bg-blue-700 transition shadow-lg shadow-blue-200">
                            Simpan Perubahan
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    <script>
        function previewImage(event) {
            const file = event.target.files[0];
            
            // Jika user batal memilih file
            if (!file) return;

            // VALIDASI UKURAN: 10MB = 10 * 1024 * 1024 bytes (10.485.760 bytes)
            if (file.size > 10485760) {
                alert('Gagal! Ukuran gambar maksimal adalah 10MB.');
                event.target.value = ''; // Reset input agar file tidak jadi terupload
                document.getElementById('preview-box').classList.add('hidden'); // Sembunyikan preview
                return;
            }

            const reader = new FileReader();
            reader.onload = function() {
                const output = document.getElementById('preview-img');
                const box = document.getElementById('preview-box');
                output.src = reader.result;
                box.classList.remove('hidden');
            };
            reader.readAsDataURL(file);
        }
    </script>
</body>

</html>
