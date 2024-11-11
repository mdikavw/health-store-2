@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-12 px-16 py-8">
        <div class="flex flex-col items-center text-center">
            <h2 class="text-3xl font-bold">{{ $category->name }}</h2>
            <p>{{ $category->description }}</p>
        </div>
        <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 xl:grid-cols-5">
            @foreach ($products as $product)
                <a class="flex flex-col items-start justify-start gap-4 transition bg-white border rounded shadow cursor-pointer hover:bg-gray-100"
                    href="{{ route('products.show', $product->slug) }}">
                    <div class="flex items-center w-full h-64">
                        <img class="object-contain w-full h-full" src="{{ asset($product->image_url) }}"
                            alt="{{ $product->name }}">
                    </div>
                    <div class="flex flex-col px-4 py-2">
                        <span class="font-bold">{{ $product->name }}</span>
                        <span class="text-sm">IDR {{ number_format($product->price, 0, ',', '.') }}</span>
                    </div>
                </a>
            @endforeach
        </div>
    </div>
@endsection
