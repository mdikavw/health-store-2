@extends('layouts.admin')

@section('page_title')
    Users List
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        @include('partials.session_flash')
        <table class="w-full bg-white rounded-lg shadow table-auto">
            <thead>
                <tr class="text-white bg-secondary">
                    <th class="px-4 py-2">ID</th>
                    <th class="px-4 py-2">Name</th>
                    <th class="px-4 py-2">Username</th>
                    <th class="px-4 py-2">Email</th>
                    <th class="px-4 py-2">Address</th>
                    <th class="px-4 py-2">Phone</th>
                    <th class="px-4 py-2">Role</th>
                    <th class="px-4 py-2">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($users as $user)
                    <tr>
                        <td class="px-4 py-2 border">{{ $user->id }}</td>
                        <td class="px-4 py-2 border">{{ $user->name }}</td>
                        <td class="px-4 py-2 border">{{ $user->username }}</td>
                        <td class="px-4 py-2 border">{{ $user->email }}</td>
                        <td class="px-4 py-2 border">{{ $user->address ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">{{ $user->phone ?? 'N/A' }}</td>
                        <td class="px-4 py-2 border">{{ $user->role->name }}</td>
                        <td class="px-4 py-2 border">
                            @if ($user->id === Auth::id())
                                <span>Unavailable</span>
                            @else
                                <button class="ml-2 text-red-600 hover:underline" type="submit"
                                    onclick="openModal('{{ $user->username }}')">Delete</button>
                            @endif
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <div class="fixed inset-0 flex items-center justify-center hidden bg-gray-900 bg-opacity-50" id="deleteModal">
            <div class="p-6 bg-white rounded-md shadow-md">
                <h3 class="text-lg font-bold">Delete User</h3>
                <p class="my-4">Are you sure you want to delete this user?</p>

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
        function openModal(username) {
            document.getElementById('deleteModal').classList.remove('hidden');
            document.getElementById('deleteForm').action = `/admin/users/${username}/delete`
        }

        function closeModal() {
            document.getElementById('deleteModal').classList.add('hidden');
        }
    </script>
@endsection
