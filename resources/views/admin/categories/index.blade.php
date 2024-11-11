@extends('layouts.admin')

@section('page_title')
    Categories List
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        @include('partials.session_flash')
        <div class="mb-4">
            <button class="p-4 text-white rounded-lg bg-primary">
                <a class="flex items-center gap-4" href="{{ route('admin.category.create') }}">
                    <i class="fa-solid fa-plus"></i>
                    <span>Create New Category</span>
                </a></button>
        </div>
        <table class="w-full bg-white rounded-lg shadow table-auto">
            <thead>
                <tr class="text-white bg-secondary">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Number of Products</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($categories as $category)
                    <tr>
                        <td class="px-4 py-2 border">{{ $category->id }}</td>
                        <td class="px-4 py-2 border">{{ $category->name }}</td>
                        <td class="px-4 py-2 border">{{ $category->products_count }}</td>
                        <td class="px-4 py-2 border">
                            <a class="text-blue-600 hover:underline"
                                href="/admin/categories/{{ $category->slug }}/edit">Edit</a>
                            <button class="ml-2 text-red-600 hover:underline" type="submit"
                                onclick="openModal('{{ $category->slug }}')">Delete</button>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50" id="deleteModal">
            <div class="p-6 bg-white rounded-md shadow-md">
                <h3 class="text-lg font-bold">Delete Category</h3>
                <p class="my-4">Are you sure you want to delete this category? All products in this category will be
                    deleted</p>

                <div class="flex justify-end gap-4">
                    <button class="px-4 py-2 text-gray-600 bg-gray-200 rounded-full" type="button" onclick="closeModal()">
                        Cancel
                    </button>
                    <form id="deleteForm" method="POST">
                        @csrf
                        @method('DELETE')
                        <button class="px-4 py-2 text-white bg-red-600 rounded-full" type="submit">
                            Delete
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script>
        function openModal(slug) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = `/admin/categories/${slug}/delete`
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
