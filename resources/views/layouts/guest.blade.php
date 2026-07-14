<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>ANImerch - Autentikasi</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* Pattern Background ala ANImerch */
        .bg-pattern {
            background-color: #f8fafc;
            background-image: radial-gradient(#94a3b8 1.5px, transparent 1.5px);
            background-size: 24px 24px;
            opacity: 0.8;
        }
    </style>
</head>

<body
    class="font-sans text-gray-900 antialiased relative min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0">
    <div class="fixed inset-0 -z-20 h-full w-full bg-pattern"></div>
    <div class="fixed inset-0 -z-10 h-full w-full bg-gradient-to-b from-blue-50/50 to-white/80"></div>

    <div class="mb-8 transform transition hover:scale-105">
        <a href="/"
            class="text-4xl font-extrabold tracking-wide flex items-center justify-center gap-3 drop-shadow-md">
            <div class="bg-blue-600 p-3 rounded-2xl shadow-lg shadow-blue-500/30">
                <svg class="w-10 h-10 text-yellow-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5"
                        d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                </svg>
            </div>
            <span class="text-blue-900">ANI<span class="text-yellow-500">merch</span></span>
        </a>
    </div>

    <div
        class="w-full sm:max-w-md px-8 py-10 bg-white shadow-2xl shadow-blue-900/10 rounded-3xl border border-gray-100 backdrop-blur-sm relative z-10 overflow-hidden">

        <div class="absolute -top-10 -right-10 w-32 h-32 bg-yellow-400 rounded-full blur-3xl opacity-20"></div>
        <div class="absolute -bottom-10 -left-10 w-32 h-32 bg-blue-600 rounded-full blur-3xl opacity-10"></div>

        <div class="relative z-20">
            {{ $slot }}
        </div>
    </div>

    <script>
        function togglePassword(inputId, button) {
            const input = document.getElementById(inputId);
            const eyeIcon = button.querySelector('.eye-icon');
            const eyeOffIcon = button.querySelector('.eye-off-icon');

            if (input.type === 'password') {
                input.type = 'text';
                eyeIcon.classList.add('hidden');
                eyeOffIcon.classList.remove('hidden');
            } else {
                input.type = 'password';
                eyeIcon.classList.remove('hidden');
                eyeOffIcon.classList.add('hidden');
            }
        }
    </script>
</body>

</html>