@extends('layouts.admin')

@section('title', 'Tambah Produk')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">

        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-slate-800">
                Add Product
            </h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium hover:text-blue-600" href="{{ route('admin.dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium hover:text-blue-600" href="{{ route('admin.products.index') }}">Products /</a>
                    </li>
                    <li class="font-medium text-blue-600">Add Product</li>
                </ol>
            </nav>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">

            <div class="border-b border-gray-200 py-4 px-8">
                <h3 class="font-semibold text-slate-800">
                    Products Description
                </h3>
            </div>

            <div class="p-8">
                <form action="{{ route('admin.products.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">
                                Product Name <span class="text-red-500">*</span>
                            </label>
                            <input type="text" name="name" placeholder="Enter product name" required
                                class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500">
                        </div>

                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">
                                Category <span class="text-red-500">*</span>
                            </label>
                            <div class="relative z-20 bg-transparent">
                                <select name="category" required
                                    class="relative z-20 w-full appearance-none rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500 cursor-pointer">
                                    <option value="" disabled selected>Pilih Kategori</option>
                                    <option value="fashion">Fashion (Baju, Celana, dll)</option>
                                    <option value="elektronik">Elektronik & Gadget</option>
                                    <option value="merch">Merchandise Anime</option>
                                </select>
                                <span class="absolute top-1/2 right-4 z-30 -translate-y-1/2">
                                    <svg class="fill-current" width="24" height="24" viewBox="0 0 24 24"
                                        fill="none">
                                        <path
                                            d="M6.10186 9.33618C6.10186 9.2223 6.13063 9.11298 6.18826 9.01569C6.31599 8.7997 6.56066 8.71813 6.77665 8.84586L12.0003 11.9365L17.2239 8.84586C17.4399 8.71813 17.6846 8.7997 17.8123 9.01569C17.87 9.11298 17.8987 9.2223 17.8987 9.33618V14.6644C17.8987 14.7783 17.87 14.8876 17.8123 14.9849C17.6846 15.2009 17.4399 15.2825 17.2239 15.1547L12.0003 12.0641L6.77665 15.1547C6.56066 15.2825 6.31599 15.2009 6.18826 14.9849C6.13063 14.8876 6.10186 14.7783 6.10186 14.6644V9.33618Z"
                                            fill="#64748B" />
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">
                                Price (Rp) <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="price" placeholder="Enter price" required
                                class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500">
                        </div>

                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">
                                Stock Quantity <span class="text-red-500">*</span>
                            </label>
                            <input type="number" name="stock" placeholder="Enter stock amount" required
                                class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="mb-3 block text-sm font-medium text-slate-700">Product Image</label>
                        <div class="relative">
                            <input type="file" name="image" accept="image/*" required
                                class="w-full cursor-pointer rounded-lg border-[1.5px] border-gray-300 bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-gray-300 file:bg-gray-50 file:py-3 file:px-5 file:text-slate-700 file:hover:bg-blue-50 focus:border-blue-500 active:border-blue-500">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="mb-3 block text-sm font-medium text-slate-700">Description</label>
                        <textarea rows="6" name="description" placeholder="Type product description here..."
                            class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500"></textarea>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-blue-600 p-3 font-medium text-white hover:bg-blue-700 transition">
                        Save Product
                    </button>

                </form>
            </div>
        </div>
    </div>
@endsection
