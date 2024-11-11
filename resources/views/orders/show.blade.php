@extends('layouts.app')

@section('page_title')
    My Order
@endsection

@section('content')
    <div class="flex flex-col gap-12">
        @include('partials.session_flash')
        <div class="flex flex-col gap-4">
            <div class="flex flex-col gap-4 p-8 bg-white rounded-lg">
                <div class="grid grid-cols-5">
                    <div class="col-span-2 font-semibold text-left">Product</div>
                    <div class="font-semibold text-left">Price</div>
                    <div class="font-semibold text-left">Quantity</div>
                    <div class="font-semibold text-left">Total</div>
                </div>
                @php
                    $orderTotalPrice = 0;
                @endphp
                @foreach ($order->orderItems as $order_item)
                    @php
                        $itemPrice = $order_item->product->price;
                        $totalPrice = $order_item->quantity * $itemPrice;
                        $orderTotalPrice += $totalPrice;
                    @endphp
                    <div class="grid items-center grid-cols-5">
                        <div class="flex col-span-2">
                            <img class="object-cover w-32 h-32 rounded" src="{{ asset($order_item->product->image_url) }}"
                                alt="{{ $order_item->product->name }}">
                        </div>
                        <div class="text-lg font-semibold">IDR {{ number_format($itemPrice, 0, ',', '.') }}
                        </div>
                        <div>
                            <span
                                class="px-4 py-2 text-lg font-medium bg-gray-100 rounded-md">{{ $order_item->quantity }}</span>
                        </div>
                        <div class="text-lg">IDR
                            {{ number_format($order_item->product->price * $order_item->quantity, 0, ',', '.') }}</div>
                    </div>
                @endforeach
                <div class="grid items-center grid-cols-5 mt-2 pt-2 border-t-[1px] border-gray-200">
                    <h3 class="col-span-4 text-lg font-bold">Total</h3>
                    <span class="text-2xl font-bold">IDR {{ number_format($orderTotalPrice, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-8 bg-white rounded-lg">
                <h3 class="text-lg font-bold">Address</h3>
                <div class="flex items-center justify-between">
                    <div class="flex flex-col gap-2">
                        <span class="text-lg font-bold">{{ Auth::user()->name }}</span>
                        <span>{{ Auth::user()->phone }}</span>
                    </div>
                    <div class="flex-grow text-right">
                        <p>{{ Auth::user()->address }}</p>
                    </div>
                    <div class="hidden w-32 lg:block">&nbsp;</div>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-8 bg-white rounded-lg">
                <h3 class="text-lg font-semibold">Payment Method</h3>
                <div>
                    {{ \App\Models\PaymentMethod::find($order->payment_method_id)->payment_name ?? 'N/A' }}
                </div>
            </div>
            @if ($order->status->name === 'pending')
                <form class="flex items-center justify-end gap-4 rounded-lg" action="/orders/payment" method="POST">
                    @csrf
                    <input name="order_id" type="hidden" value="{{ $order->id }}">
                    <button class="p-4 text-white rounded-lg bg-primary hover:bg-primary-dark" type="submit">
                        Complete Payment
                    </button>
                </form>
            @endif
        </div>
    </div>
    </div>
@endsection
