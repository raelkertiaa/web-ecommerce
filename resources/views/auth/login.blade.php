<x-guest-layout>
    <div class="text-center mb-8">
        <h2 class="text-2xl font-bold text-gray-800">Selamat Datang Kembali!</h2>
        <p class="text-sm text-gray-500 mt-1">Silakan masuk ke akun kolektormu.</p>
    </div>

    <x-auth-session-status class="mb-4" :status="session('status')" />

    <form method="POST" action="{{ route('login') }}" class="space-y-5">
        @csrf

        <div>
            <label for="email" class="block text-sm font-bold text-gray-700 mb-1">Email</label>
            <input id="email" type="email" name="email" :value="old('email')" required autofocus
                autocomplete="username"
                class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm bg-gray-50 p-3"
                placeholder="contoh@email.com">
            <x-input-error :messages="$errors->get('email')" class="mt-2" />
        </div>

        <div>
            <div class="flex justify-between items-center mb-1">
                <label for="password" class="block text-sm font-bold text-gray-700">Password</label>
                @if (Route::has('password.request'))
                    <a class="text-xs font-semibold text-blue-600 hover:text-blue-800 hover:underline transition"
                        href="{{ route('password.request') }}">
                        Lupa password?
                    </a>
                @endif
            </div>
            <div class="relative">
                <input id="password" type="password" name="password" required autocomplete="current-password"
                    class="w-full rounded-xl border-gray-300 focus:border-blue-500 focus:ring focus:ring-blue-200 transition shadow-sm bg-gray-50 p-3 pr-12"
                    placeholder="••••••••">

                <button type="button" onclick="togglePassword('password', this)"
                    class="absolute inset-y-0 right-0 pr-4 flex items-center text-gray-400 hover:text-blue-600 transition">
                    <svg class="h-5 w-5 eye-icon" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                    </svg>
                    <svg class="h-5 w-5 eye-off-icon hidden" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                    </svg>
                </button>
            </div>
            <x-input-error :messages="$errors->get('password')" class="mt-2" />
        </div>

        <div class="flex items-center pt-2">
            <input id="remember_me" type="checkbox" name="remember"
                class="rounded border-gray-300 text-blue-600 shadow-sm focus:ring-blue-500 w-4 h-4 cursor-pointer">
            <label for="remember_me" class="ml-2 text-sm text-gray-600 font-medium cursor-pointer">Ingat saya</label>
        </div>

        <div class="pt-4">
            <button type="submit"
                class="w-full bg-blue-600 text-white font-bold py-3.5 rounded-xl hover:bg-blue-700 focus:ring-4 focus:ring-blue-300 transition shadow-lg shadow-blue-500/30 transform hover:-translate-y-0.5">
                MASUK SEKARANG
            </button>
        </div>

        <div class="text-center mt-6 text-sm text-gray-600 border-t pt-6">
            Belum punya akun?
            <a href="{{ route('register') }}"
                class="font-bold text-orange-500 hover:text-orange-600 hover:underline transition">
                Daftar di sini
            </a>
        </div>
    </form>
</x-guest-layout>