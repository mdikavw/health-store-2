@extends('layouts.admin')

@section('page_title')
    Edit Product
@endsection

@section('content')
    <div class="flex flex-col">
        @include('partials.session_flash')
        <form action="/admin/products/{{ $product->slug }}/edit" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="flex justify-start w-full gap-12 mb-6">
                <div class="flex flex-col w-2/5 gap-4">
                    <h3 class="font-bold">Product Image</h3>
                    @if ($product->image_url)
                        <div class="flex justify-center w-full">
                            <img class="object-cover max-w-64 max-h-64" src="{{ asset($product->image_url) }}"
                                alt="{{ $product->name }}">
                        </div>
                    @else
                        <div class="bg-secondary w-full h-[200px] flex items-center justify-center">
                            <h3>No image</h3>
                        </div>
                    @endif
                    @include('partials.input', [
                        'label' => 'Edit Image',
                        'name' => 'image',
                        'type' => 'file',
                    ])
                </div>
                <div class="flex flex-col w-3/5 gap-4">
                    @include('partials.input', [
                        'label' => 'Product Name',
                        'name' => 'name',
                        'value' => $product->name,
                        'required' => true,
                    ])

                    @include('partials.input', [
                        'label' => 'Price',
                        'name' => 'price',
                        'type' => 'number',
                        'value' => $product->price,
                        'required' => true,
                    ])

                    <div class="form-group">
                        <h3>Category</h3>
                        <select name="category_id">
                            @foreach (App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}"
                                    {{ $category->id == $product->category_id ? 'selected' : '' }}>{{ $category->name }}
                                </option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    @include('partials.input', [
                        'label' => 'Stock',
                        'name' => 'stock',
                        'value' => $product->stock,
                    ])
                </div>
            </div>
            <div class="form-group">
                <h3>Description</h3>
                <textarea id="" name="description" cols="40" rows="5">{{ $product->description }}</textarea>
                @error('description')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button class="p-4 mt-4 text-white rounded-lg bg-primary" type="submit">Edit Product</button>
        </form>
    </div>
@endsection
