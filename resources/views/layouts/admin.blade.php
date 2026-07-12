<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title') - Admin Panel</title>

    <script src="https://cdn.tailwindcss.com"></script>

    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/apexcharts"></script>

    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
        }

        [x-cloak] {
            display: none !important;
        }

        /* Warna Khusus TailAdmin */
        .bg-boxdark {
            background-color: #1C2434;
        }

        .text-bodydark {
            color: #DEE4EE;
        }

        .text-bodydark2 {
            color: #8A99AF;
        }
    </style>
</head>

<body class="bg-[#F1F5F9] text-slate-900" x-data="{ sidebarOpen: false }">

    <div class="flex h-screen overflow-hidden">

        <aside :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
            class="absolute left-0 top-0 z-50 flex h-screen w-72 flex-col overflow-y-hidden bg-[#1C2434] duration-300 ease-linear lg:static lg:translate-x-0">

            <div class="flex items-center justify-between gap-2 px-6 py-5.5 lg:py-6.5">
                <a href="{{ route('admin.dashboard') }}" class="text-2xl font-bold text-white flex items-center gap-3">
                    <div class="w-10 h-10 bg-[#3C50E0] rounded flex items-center justify-center text-white">
                        <svg class="fill-current" width="20" height="20" viewBox="0 0 32 32">
                            <path
                                d="M16 0C7.163 0 0 7.163 0 16s7.163 16 16 16 16-7.163 16-16S24.837 0 16 0zm0 28C9.373 28 4 22.627 4 16S9.373 4 16 4s12 5.373 12 12-5.373 12-12 12z" />
                        </svg>
                    </div>
                    <span>ANImerch</span>
                </a>
                <button @click.stop="sidebarOpen = !sidebarOpen" class="block lg:hidden text-gray-400">
                    <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>
            </div>

            <div class="flex flex-col overflow-y-auto duration-300 ease-linear">
                <nav class="mt-5 px-4 py-4 lg:mt-9 lg:px-6">
                    <h3 class="mb-4 ml-4 text-sm font-semibold text-[#8A99AF]">MENU UTAMA</h3>

                    <ul class="mb-6 flex flex-col gap-1.5">

                        <li>
                            <a href="{{ route('admin.dashboard') }}"
                                class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium duration-300 ease-in-out hover:bg-[#333A48] {{ request()->routeIs('admin.dashboard') ? 'bg-[#333A48] text-white' : 'text-[#DEE4EE]' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                                    </path>
                                </svg>
                                Dashboard
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.products.index') }}"
                                class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium duration-300 ease-in-out hover:bg-[#333A48] {{ request()->routeIs('admin.products.*') ? 'bg-[#333A48] text-white' : 'text-[#DEE4EE]' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4">
                                    </path>
                                </svg>
                                Produk
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.orders.index') }}"
                                class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium duration-300 ease-in-out hover:bg-[#333A48] {{ request()->routeIs('admin.orders.*') ? 'bg-[#333A48] text-white' : 'text-[#DEE4EE]' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z">
                                    </path>
                                </svg>
                                Pesanan Masuk
                            </a>
                        </li>

                        <li>
                            <a href="{{ route('admin.reports.index') }}"
                                class="group relative flex items-center gap-2.5 rounded-sm px-4 py-2 font-medium duration-300 ease-in-out hover:bg-[#333A48] {{ request()->routeIs('admin.reports.*') ? 'bg-[#333A48] text-white' : 'text-[#DEE4EE]' }}">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 002 2h2a2 2 0 002-2z">
                                    </path>
                                </svg>
                                Laporan Keuangan
                            </a>
                        </li>

                    </ul>
                </nav>
            </div>
        </aside>

        <div class="relative flex flex-1 flex-col overflow-y-auto overflow-x-hidden">

            <header class="sticky top-0 z-40 flex w-full bg-white drop-shadow-1 shadow-sm">
                <div class="flex flex-grow items-center justify-between px-4 py-4 shadow-2 md:px-6 2xl:px-11">

                    <div class="flex items-center gap-2 sm:gap-4 lg:hidden">
                        <button @click.stop="sidebarOpen = !sidebarOpen"
                            class="block rounded-sm border border-stroke bg-white p-1.5 shadow-sm">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16"></path>
                            </svg>
                        </button>
                    </div>

                    <div class="hidden sm:block w-full max-w-xl">
                    </div>

                    <div class="flex items-center gap-3">
                        <div class="hidden text-right lg:block">
                            <span class="block text-sm font-medium text-black">{{ Auth::user()->name }}</span>
                            <span class="block text-xs text-gray-500">Administrator</span>
                        </div>
                        <div class="h-10 w-10 rounded-full bg-gray-200 overflow-hidden border border-slate-200">
                            <img src="https://ui-avatars.com/api/?name={{ urlencode(Auth::user()->name) }}&background=random"
                                alt="User" />
                        </div>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit"
                                class="text-sm font-medium text-red-500 hover:text-red-700 ml-2 transition">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="bg-[#F1F5F9] h-full">
                <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>

</html>
