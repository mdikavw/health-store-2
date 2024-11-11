@extends('layouts.home')

@section('content')
    <div class="flex flex-col gap-12 px-16 py-8">
        <div class="flex flex-col gap-6">
            <h2 class="text-xl font-bold">Categories</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($categories as $category)
                    <a class="flex items-center gap-4 p-4 transition bg-white border rounded-lg shadow-sm cursor-pointer hover:bg-gray-100"
                        href="{{ route('categories.show', $category->slug) }}">
                        <i class="{{ $category->icon }} text-secondary"></i>
                        <span>{{ $category->name }}</span>
                    </a>
                @endforeach
            </div>
        </div>

        <div class="flex flex-col gap-6">
            <h2 class="text-xl font-bold">Products</h2>
            <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
                @foreach ($products as $product)
                    <a class="flex items-center justify-start gap-4 px-4 py-2 transition bg-white border rounded-lg shadow-sm cursor-pointer hover:bg-gray-100"
                        href="{{ route('products.show', $product->slug) }}">
                        <div class="flex items-center h-16 w-1/2full">
                            <img class="object-contain w-full h-full" src="{{ asset($product->image_url) }}"
                                alt="{{ $product->name }}">
                        </div>
                        <div class="flex flex-col px-4 py-2">
                            <span class="font-semibold">{{ $product->name }}</span>
                            <span class="text-sm">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </div>
@endsection
