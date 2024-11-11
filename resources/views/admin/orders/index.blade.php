@extends('layouts.admin')

@section('page_title')
    Orders List
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        @include('partials.session_flash')
        <table class="w-full bg-white rounded-lg shadow table-auto">
            <thead>
                <tr class="text-white bg-secondary">
                    <th class="px-4 py-2">Order ID</th>
                    <th class="px-4 py-2">Customer</th>
                    <th class="px-4 py-2">Status</th>
                    <th class="px-4 py-2">Date</th>
                    <th class="px-4 py-2">Action</th>
                </tr>
            </thead>
            <tbody>
                @foreach ($orders as $order)
                    <tr>
                        <td class="px-4 py-2 border">{{ $order->id }}</td>
                        <td class="px-4 py-2 border">{{ $order->user->name }}</td>
                        <td class="px-4 py-2 border">
                            <form id="editForm{{ $order->id }}"
                                onchange="handleEditForm({{ $order->status->id }}, {{ $order->id }})"
                                action="/admin/orders/{{ $order->id }}/update-status" method="POST">
                                @csrf
                                @method('PATCH')
                                <select class="flex items-center w-full h-full" name="status_id">
                                    @foreach ($statuses as $status)
                                        <option class="text-black bg-white" value="{{ $status->id }}"
                                            {{ $order->status->id === $status->id ? 'selected' : '' }}>
                                            {{ ucwords($status->name) }}</option>
                                    @endforeach
                                </select>
                            </form>
                        </td>
                        <td class="px-4 py-2 border">{{ $order->created_at }}</td>
                        <td class="px-4 py-2 border">
                            <div class="flex items-center justify-center">
                                <button class="hidden ml-2 text-primary hover:underline" id="editButton{{ $order->id }}"
                                    type="submit" onclick="submitEditForm({{ $order->id }})">
                                    Edit
                                </button>
                                <form id="deleteForm" action="/admin/orders/{{ $order->id }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button class="ml-2 text-red-600 hover:underline" type="submit">Delete</button>
                                </form>
                            </div>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    <script>
        function handleEditForm(statusId, orderId) {
            var form = document.getElementById('editForm' + orderId);
            var selectedStatus = form.querySelector('select[name="status_id"]').value;
            var editButton = document.getElementById('editButton' + orderId)
            if (selectedStatus !== statusId.toString()) {
                editButton.classList.remove('hidden')
            } else {
                editButton.classList.add('hidden')
            }
        }

        function submitEditForm(orderId) {
            var form = document.getElementById('editForm' + orderId)
            form.submit()
        }
    </script>
@endsection
