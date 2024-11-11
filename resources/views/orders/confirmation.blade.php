@extends('layouts.app')

@section('page_title')
    Order Confirmation
@endsection

@section('content')
    <div class="flex flex-col gap-12">
        @include('partials.session_flash')
        <form class="flex flex-col gap-4" action="/orders/checkout" method="post">
            @csrf
            <div class="flex flex-col gap-4 p-8 bg-white rounded-lg">
                <h3 class="text-lg font-semibold">Ordered Products</h3>
                <div class="grid grid-cols-5">
                    <div class="col-span-2 font-semibold text-left">Product</div>
                    <div class="font-semibold text-left">Price</div>
                    <div class="font-semibold text-left">Quantity</div>
                    <div class="font-semibold text-left">Total</div>
                </div>
                @php
                    $orderTotalPrice = 0;
                @endphp
                @foreach ($cart_items as $cartItem)
                    @php
                        $itemPrice = $cartItem->product->price;
                        $totalPrice = $cartItem->quantity * $itemPrice;
                        $orderTotalPrice += $totalPrice;
                    @endphp
                    <input name="selected_items[]" type="hidden" value="{{ $cartItem->id }}">
                    <div class="grid items-center grid-cols-5">
                        <div class="flex col-span-2">
                            <img class="object-cover w-32 h-32 rounded" src="{{ asset($cartItem->product->image_url) }}"
                                alt="{{ $cartItem->product->name }}">
                        </div>
                        <div class="text-lg font-semibold">IDR {{ number_format($itemPrice, 0, ',', '.') }}
                        </div>
                        <div>
                            <span
                                class="px-4 py-2 text-lg font-medium bg-gray-100 rounded-md">{{ $cartItem->quantity }}</span>
                        </div>
                        <div class="text-lg">IDR
                            {{ number_format($cartItem->product->price * $cartItem->quantity, 0, ',', '.') }}</div>
                    </div>
                @endforeach
                <div class="grid items-center grid-cols-5 mt-2 pt-2 border-t-[1px] border-gray-200">
                    <h3 class="col-span-4 text-lg font-bold">Total</h3>
                    <span class="text-2xl font-bold">IDR {{ number_format($orderTotalPrice, 0, ',', '.') }}</span>
                </div>
            </div>
            <div class="flex flex-col gap-4 p-8 bg-white rounded-lg">
                <h3 class="text-lg font-semibold">Address</h3>
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
                    <select class="w-full p-4 border rounded-lg outline-none" name="payment_method_id">
                        @foreach (\App\Models\PaymentMethod::all() as $method)
                            <option value="{{ $method->id }}">{{ $method->payment_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="flex items-center justify-between gap-4 p-8 bg-white rounded-lg">
                <div class="text-xl font-bold" id="totalAmount">Total: IDR
                    {{ number_format($orderTotalPrice, 0, ',', '.') }}</div>
                <button class="p-4 text-white rounded-lg bg-primary hover:bg-primary-dark" type="submit">
                    Checkout
                </button>
            </div>
        </form>
    </div>
@endsection
