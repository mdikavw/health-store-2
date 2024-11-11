@extends('layouts.admin')

@section('page_title')
    Admin Dashboard
@endsection

@section('content')
    <div class="flex flex-col gap-4">
        <div class="grid grid-cols-4 gap-6">
            <div class="p-6 bg-white rounded-lg">
                <h2 class="text-sm font-semibold">Total Products</h2>
                <p class="text-3xl">{{ $productCount }}</p>
            </div>

            <div class="p-6 bg-white rounded-lg">
                <h2 class="text-sm font-semibold">Total Categories</h2>
                <p class="text-3xl">{{ $categoryCount }}</p>
            </div>

            <div class="p-6 bg-white rounded-lg">
                <h2 class="text-sm font-semibold">Total Orders</h2>
                <p class="text-3xl">{{ $orderCount }}</p>
            </div>

            <div class="p-6 bg-white rounded-lg">
                <h2 class="text-sm font-semibold">Total Users</h2>
                <p class="text-3xl">{{ $userCount }}</p>
            </div>
        </div>
        <div>
            <h2 class="mb-4 text-xl font-bold">Recent Orders</h2>
            <table class="w-full bg-white rounded-lg table-auto">
                <thead>
                    <tr class="text-white bg-secondary">
                        <th class="px-4 py-2">Order ID</th>
                        <th class="px-4 py-2">Customer</th>
                        <th class="px-4 py-2">Status</th>
                        <th class="px-4 py-2">Date</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($recentOrders as $order)
                        <tr>
                            <td class="px-4 py-2 border">{{ $order->id }}</td>
                            <td class="px-4 py-2 border">{{ $order->user->name }}</td>
                            <td class="px-4 py-2 border">{{ $order->status->name }}</td>
                            <td class="px-4 py-2 border">{{ $order->created_at }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
@endsection
