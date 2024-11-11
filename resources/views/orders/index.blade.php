@extends('layouts.app')

@section('page_title')
    My Orders
@endsection

@section('content')
    <div class="flex flex-col gap-12">
        @include('partials.session_flash')

        <div class="flex flex-col gap-4">
            <div class="grid grid-cols-5 p-4 bg-white rounded-lg">
                <span class="col-span-2">Product</span>
                <span>Status</span>
                <span>Total</span>
                <span>Action</span>
            </div>
            @forelse($orders as $order)
                <div class="grid items-center grid-cols-5 p-4 bg-white rounded-lg">
                    <ul class="grid col-span-2 ml-6 list-disc">
                        @foreach ($order->orderItems as $item)
                            <li>
                                {{ $item->product->name }} - {{ $item->quantity }} x
                                ${{ number_format($item->product->price, 2) }}
                            </li>
                        @endforeach
                    </ul>
                    <span>{{ ucwords($order->status->name) }}</span>
                    <span>IDR {{ number_format($order->total, 0, ',', '.') }}</span>
                    <a class="text-primary hover:underline" href="{{ route('orders.show', $order->id) }}">
                        View Order Details
                    </a>

                </div>
            @empty
                <p>You have no orders yet.</p>
            @endforelse
        </div>
    </div>
@endsection
