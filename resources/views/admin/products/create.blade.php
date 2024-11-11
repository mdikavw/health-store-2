@extends('layouts.admin')

@section('page_title')
    Add New Product
@endsection

@section('content')
    <div class="flex flex-col">
        @include('partials.session_flash')
        <form action="/admin/products/create" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="flex justify-start w-full gap-12 mb-6">
                <div class="flex flex-col w-2/5 gap-4">
                    @include('partials.input', [
                        'label' => 'Add Image',
                        'name' => 'image',
                        'type' => 'file',
                    ])
                </div>
                <div class="flex flex-col w-3/5 gap-4">
                    @include('partials.input', [
                        'label' => 'Product Name',
                        'name' => 'name',
                        'type' => 'text',
                        'required' => true,
                    ])

                    @include('partials.input', [
                        'label' => 'Price',
                        'name' => 'price',
                        'type' => 'number',
                        'required' => true,
                    ])

                    <div class="form-group">
                        <h3>Category</h3>
                        <select name="category_id">
                            @foreach (App\Models\Category::all() as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                        @error('category_id')
                            <p class="text-red-500">{{ $message }}</p>
                        @enderror
                    </div>

                    @include('partials.input', [
                        'label' => 'Stock',
                        'name' => 'stock',
                        'type' => 'text',
                    ])
                </div>
            </div>
            <div class="form-group">
                <h3>Description</h3>
                <textarea id="" name="description" cols="40" rows="5"></textarea>
                @error('description')
                    <p class="text-red-500">{{ $message }}</p>
                @enderror
            </div>
            <button class="p-4 mt-4 text-white rounded-lg bg-primary" type="submit">Create Product</button>
        </form>
    </div>
@endsection
