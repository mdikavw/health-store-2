@extends('layouts.admin')

@section('page_title')
    Edit Category
@endsection

@section('content')
    <div class="flex flex-col">
        @include('partials.session_flash')
        <form action="/admin/categories/{{ $category->slug }}/edit" method="POST">
            @csrf
            @method('PUT')
            <div class="flex flex-col gap-4">
                <div class="flex gap-4">
                    <div class="flex-grow form-group">
                        @include('partials.input', [
                            'label' => 'Category Name',
                            'name' => 'name',
                            'type' => 'text',
                            'value' => $category->name,
                            'required' => true,
                        ])
                    </div>
                    <div class="flex-grow form-group">
                        @include('partials.input', [
                            'label' => 'Font Awesome Icon',
                            'name' => 'icon',
                            'type' => 'text',
                            'value' => $category->icon,
                        ])
                    </div>
                </div>
                <div class="form-group">
                    <h3>Description</h3>
                    <textarea id="" name="description" cols="40" rows="5">{{ $category->description }}</textarea>
                    @error('description')
                        <p class="text-red-500">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button class="p-4 mt-4 text-white rounded-lg bg-primary" type="submit">Edit Category</button>
        </form>
    </div>
@endsection
