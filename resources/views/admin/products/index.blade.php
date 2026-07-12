@extends('layouts.admin')

@section('title', 'Daftar Produk')

@section('content')
    <div class="rounded-sm border border-stroke bg-white px-5 pt-6 pb-2.5 shadow-sm sm:px-7.5 xl:pb-1">

        <div class="flex flex-col gap-4 sm:flex-row sm:items-center sm:justify-between mb-6">

            <h4 class="text-xl font-bold text-black">
                Product List
            </h4>

            <div class="flex flex-col gap-4 sm:flex-row sm:items-center">

                <form action="{{ route('admin.products.index') }}" method="GET" class="relative">
                    <button type="submit" class="absolute top-1/2 left-4 -translate-y-1/2">
                        <svg class="fill-body hover:fill-primary" width="20" height="20" viewBox="0 0 20 20"
                            fill="none">
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M9.16666 3.33332C5.945 3.33332 3.33332 5.945 3.33332 9.16666C3.33332 12.3883 5.945 15 9.16666 15C12.3883 15 15 12.3883 15 9.16666C15 5.945 12.3883 3.33332 9.16666 3.33332ZM1.66666 9.16666C1.66666 5.02452 5.02452 1.66666 9.16666 1.66666C13.3088 1.66666 16.6667 5.02452 16.6667 9.16666C16.6667 13.3088 13.3088 16.6667 9.16666 16.6667C5.02452 16.6667 1.66666 13.3088 1.66666 9.16666Z"
                                fill="#64748B" />
                            <path fill-rule="evenodd" clip-rule="evenodd"
                                d="M13.2857 13.2857C13.6112 12.9603 14.1388 12.9603 14.4642 13.2857L18.0892 16.9107C18.4147 17.2362 18.4147 17.7638 18.0892 18.0892C17.7638 18.4147 17.2362 18.4147 16.9107 18.0892L13.2857 14.4642C12.9603 14.1388 12.9603 13.6112 13.2857 13.2857Z"
                                fill="#64748B" />
                        </svg>
                    </button>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari nama produk..."
                        class="w-full rounded-md border border-stroke bg-transparent py-2.5 pl-12 pr-4 text-black outline-none focus:border-blue-500 focus-visible:shadow-none sm:w-64">
                </form>

                <a href="{{ route('admin.products.create') }}"
                    class="inline-flex items-center justify-center gap-2.5 rounded-md bg-blue-600 py-3 px-6 text-center font-medium text-white hover:bg-opacity-90">
                    <span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4" />
                        </svg>
                    </span>
                    Add Product
                </a>

            </div>
        </div>

        <div class="flex flex-col">
            <div class="grid grid-cols-3 rounded-sm bg-gray-100 sm:grid-cols-5 p-2.5">
                <div class="p-2.5 xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Product</h5>
                </div>
                <div class="p-2.5 text-center xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Price</h5>
                </div>
                <div class="p-2.5 text-center xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Stock</h5>
                </div>
                <div class="hidden p-2.5 text-center sm:block xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Created At</h5>
                </div>
                <div class="hidden p-2.5 text-center sm:block xl:p-5">
                    <h5 class="text-sm font-medium uppercase xsm:text-base">Action</h5>
                </div>
            </div>

            @foreach ($products as $product)
                <div class="grid grid-cols-3 border-b border-stroke sm:grid-cols-5 p-2.5 hover:bg-gray-50 transition">

                    <div class="flex items-center gap-3 p-2.5 xl:p-5">
                        <div class="flex-shrink-0 h-12 w-12 rounded overflow-hidden border border-gray-200">
                            <img src="{{ asset('storage/' . $product->image) }}" alt="Product"
                                class="h-full w-full object-cover">
                        </div>
                        <p class="hidden text-black sm:block font-medium">{{ $product->name }}</p>
                    </div>

                    <div class="flex items-center justify-center p-2.5 xl:p-5">
                        <p class="text-black">Rp {{ number_format($product->price, 0, ',', '.') }}</p>
                    </div>

                    <div class="flex items-center justify-center p-2.5 xl:p-5">
                        @if ($product->stock > 0)
                            <p class="inline-flex rounded-full bg-green-100 px-3 py-1 text-sm font-medium text-green-600">
                                {{ $product->stock }} Stock
                            </p>
                        @else
                            <p class="inline-flex rounded-full bg-red-100 px-3 py-1 text-sm font-medium text-red-600">
                                Out of Stock
                            </p>
                        @endif
                    </div>

                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5">
                        <p class="text-black">{{ $product->created_at->format('d M Y') }}</p>
                    </div>

                    <div class="hidden items-center justify-center p-2.5 sm:flex xl:p-5 gap-4">

                        <a href="{{ route('admin.products.edit', $product->id) }}"
                            class="text-slate-500 hover:text-blue-600 transition-colors duration-200" title="Edit">
                            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" />
                            </svg>
                        </a>

                        <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST"
                            onsubmit="return confirm('Yakin ingin menghapus produk ini?');" class="flex items-center">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-slate-500 hover:text-red-600 transition-colors duration-200"
                                title="Hapus">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M14.74 9l-.346 9m-4.788 0L9.26 9m9.968-3.21c.342.052.682.107 1.022.166m-1.022-.165L18.16 19.673a2.25 2.25 0 01-2.244 2.077H8.084a2.25 2.25 0 01-2.244-2.077L4.772 5.79m14.456 0a48.108 48.108 0 00-3.478-.397m-12 .562c.34-.059.68-.114 1.022-.165m0 0a48.11 48.11 0 013.478-.397m7.5 0v-.916c0-1.18-.91-2.164-2.09-2.201a51.964 51.964 0 00-3.32 0c-1.18.037-2.09 1.022-2.09 2.201v.916m7.5 0a48.667 48.667 0 00-7.5 0" />
                                </svg>
                            </button>
                        </form>

                    </div>
                </div>
            @endforeach

            <div class="p-4">
                {{ $products->links() }}
            </div>
        </div>
    </div>
@endsection
