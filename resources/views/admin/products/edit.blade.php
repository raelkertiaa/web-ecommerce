@extends('layouts.admin')

@section('title', 'Edit Produk')

@section('content')
    <div class="mx-auto max-w-screen-2xl p-4 md:p-6 2xl:p-10">
        <div class="mb-6 flex flex-col gap-3 sm:flex-row sm:items-center sm:justify-between">
            <h2 class="text-2xl font-bold text-slate-800">Edit Product</h2>
            <nav>
                <ol class="flex items-center gap-2">
                    <li><a class="font-medium hover:text-blue-600" href="{{ route('admin.dashboard') }}">Dashboard /</a></li>
                    <li><a class="font-medium hover:text-blue-600" href="{{ route('admin.products.index') }}">Products /</a>
                    </li>
                    <li class="font-medium text-blue-600">Edit</li>
                </ol>
            </nav>
        </div>

        <div class="rounded-xl border border-gray-200 bg-white shadow-sm">
            <div class="p-8">
                <form action="{{ route('admin.products.update', $product->id) }}" method="POST"
                    enctype="multipart/form-data">
                    @csrf
                    @method('PUT')

                    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-2">

                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">Product Name</label>
                            <input type="text" name="name" value="{{ old('name', $product->name) }}" required
                                class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500">
                        </div>

                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">Category</label>
                            <div class="relative z-20 bg-transparent">
                                <select name="category" required
                                    class="relative z-20 w-full appearance-none rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500 cursor-pointer">

                                    <option value="fashion"
                                        {{ old('category', $product->category) == 'fashion' ? 'selected' : '' }}>Fashion
                                        (Baju, Celana, dll)</option>
                                    <option value="elektronik"
                                        {{ old('category', $product->category) == 'elektronik' ? 'selected' : '' }}>
                                        Elektronik & Gadget</option>
                                    <option value="merch"
                                        {{ old('category', $product->category) == 'merch' ? 'selected' : '' }}>Merchandise
                                        Anime</option>

                                </select>
                            </div>
                        </div>
                    </div>

                    <div class="mb-6 grid grid-cols-1 gap-6 xl:grid-cols-2">
                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">Price (Rp)</label>
                            <input type="number" name="price" value="{{ old('price', $product->price) }}" required
                                class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500">
                        </div>
                        <div>
                            <label class="mb-3 block text-sm font-medium text-slate-700">Stock Quantity</label>
                            <input type="number" name="stock" value="{{ old('stock', $product->stock) }}" required
                                class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500">
                        </div>
                    </div>

                    <div class="mb-6">
                        <label class="mb-3 block text-sm font-medium text-slate-700">Product Image</label>

                        @if ($product->image)
                            <div class="mb-4 w-32 rounded-lg border border-gray-200 p-1">
                                <img src="{{ asset('storage/' . $product->image) }}" alt="Current Image" class="rounded">
                                <p class="mt-1 text-center text-xs text-gray-500">Gambar Saat Ini</p>
                            </div>
                        @endif

                        <div class="relative">
                            <input type="file" name="image" accept="image/*"
                                class="w-full cursor-pointer rounded-lg border-[1.5px] border-gray-300 bg-transparent font-medium outline-none transition file:mr-5 file:border-collapse file:cursor-pointer file:border-0 file:border-r file:border-solid file:border-gray-300 file:bg-gray-50 file:py-3 file:px-5 file:text-slate-700 file:hover:bg-blue-50 focus:border-blue-500 active:border-blue-500">
                        </div>
                    </div>

                    <div class="mb-8">
                        <label class="mb-3 block text-sm font-medium text-slate-700">Description</label>
                        <textarea rows="6" name="description"
                            class="w-full rounded-lg border-[1.5px] border-gray-300 bg-transparent py-3 px-5 text-slate-700 outline-none transition focus:border-blue-500 active:border-blue-500">{{ old('description', $product->description) }}</textarea>
                    </div>

                    <button type="submit"
                        class="flex w-full justify-center rounded-lg bg-blue-600 p-3 font-medium text-white hover:bg-blue-700 transition">
                        Update Product
                    </button>
                </form>
            </div>
        </div>
    </div>
@endsection
