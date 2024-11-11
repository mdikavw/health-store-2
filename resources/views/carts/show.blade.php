@extends('layouts.app')

@section('page_title')
    My Cart
@endsection
@section('content')
    <div class="flex flex-col gap-12">
        @include('partials.session_flash')
        <form id="checkoutForm" action="/orders/confirmation" method="POST">
            @csrf
            <div>
                <div class="grid grid-cols-7 gap-4 p-4 text-white rounded-lg shadow-sm bg-secondary">
                    <div class="col-span-3 font-semibold text-left">Product</div>
                    <div class="font-semibold text-left">Price</div>
                    <div class="font-semibold text-left">Quantity</div>
                    <div class="font-semibold text-left">Total Price</div>
                    <div class="font-semibold text-left">Actions</div>
                </div>
                <div>
                    @foreach ($cart->cartItems as $cartItem)
                        @php
                            $itemPrice = $cartItem->product->price;
                            $totalPrice = $cartItem->quantity * $itemPrice;
                        @endphp
                        <div class="grid items-center grid-cols-7 gap-4 p-4 mt-4 bg-white border-b rounded-lg">
                            <div class="flex items-center col-span-3 gap-8">
                                <input class="form-checkbox" name="selected_items[]" type="checkbox"
                                    value="{{ $cartItem->id }}" onchange="updateTotal()">
                                <img class="object-cover w-32 h-32 rounded" src="{{ asset($cartItem->product->image_url) }}"
                                    alt="{{ $cartItem->product->name }}">
                                <span class="font-medium">{{ $cartItem->product->name }}</span>
                            </div>
                            <div class="font-medium">IDR {{ number_format($itemPrice, 0, ',', '.') }}</div>
                            <div>
                                <span class="px-4 py-2 font-medium bg-gray-100 rounded-md">{{ $cartItem->quantity }}</span>
                            </div>
                            <div class="font-medium total-price" data-total="{{ $totalPrice }}">IDR
                                {{ number_format($totalPrice, 0, ',', '.') }}</div>
                            <div>
                                <button class="flex items-center w-auto gap-4 text-red-500 rounded-full cursor-pointer"
                                    onclick="deleteForm(event, '{{ $cartItem->id }}')">
                                    <i class="fa-solid fa-trash"></i>
                                    <span>Delete</span>
                                </button>

                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
            <div
                class="flex items-center justify-between p-4 mt-4 bg-white rounded-lg {{ count($cart->cartItems) === 0 ? 'hidden' : '' }}">
                <div class="text-xl font-bold" id="totalAmount">Total: IDR 0</div>
                <button class="p-4 text-white rounded-full bg-primary hover:bg-primary-dark" type="submit">
                    Checkout Selected Items
                </button>
            </div>
        </form>
        <form id="deleteForm" action="/cart/delete" method="POST">
            @csrf
            @method('DELETE')
            <input id="deletedCartItemId" name="id" type="hidden">
        </form>
    </div>
    <script>
        function updateTotal() {
            let total = 0;
            const selectedItems = document.querySelectorAll('input[name="selected_items[]"]:checked');

            selectedItems.forEach((checkbox) => {
                const itemRow = checkbox.closest('.grid');
                const totalPrice = parseInt(itemRow.querySelector('.total-price').getAttribute('data-total'), 10);
                total += totalPrice;
            });

            document.getElementById('totalAmount').textContent = 'Total: IDR ' + total;
        }

        function deleteForm(event, id) {
            event.preventDefault()
            document.getElementById('deletedCartItemId').value = id
            document.getElementById('deleteForm').submit();
        }
    </script>
@endsection
