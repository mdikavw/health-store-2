@extends('layouts.app')

@section('content')
    <div class="flex flex-col gap-12">
        @include('partials.session_flash')
        <div class="flex justify-center w-full gap-12">
            <div class="flex flex-col items-start w-2/5 gap-4">
                @if ($product->image_url)
                    <div class="flex justify-center w-full">
                        <img class="object-cover w-64 h-64" src="{{ asset($product->image_url) }}" alt="{{ $product->name }}">
                    </div>
                @else
                    <div class="bg-secondary w-full h-[200px] flex items-center justify-center">
                        <h3>No image</h3>
                    </div>
                @endif
            </div>
            <div class="flex flex-col w-3/5 gap-8">
                <div class="flex flex-col gap-4">
                    <h2 class="text-2xl font-medium">{{ $product->name }}</h2>
                    <h3 class="text-3xl font-bold">IDR {{ number_format($product->price, 0, ',', '.') }}</h3>
                </div>
                <div class="grid grid-cols-[auto_1fr] items-center gap-4">
                    <span>Category</span>
                    <span class="font-medium">{{ $product->category->name }}</span>

                    <span>Stock</span>
                    <span class="font-medium">{{ $product->stock }}</span>
                </div>
                <form class="flex flex-col gap-8" id="productForm" method="POST">
                    @csrf
                    <input name="product_id" type="hidden" value="{{ $product->id }}">
                    <input name="cart_id" type="hidden" value="{{ Auth::check() ? Auth::user()->cart->id : '' }}">
                    <div class="flex items-center h-8">
                        <button
                            class="flex items-center justify-center h-full px-4 py-2 font-bold text-white rounded-l bg-secondary"
                            type="button" onclick="decrease()"><span>-</span></button>
                        <input class="w-12 h-full text-center" id="quantity" name="quantity" type="number" value="1"
                            min="1">
                        <button
                            class="flex items-center justify-center h-full px-4 py-2 font-bold text-white rounded-r bg-secondary"
                            type="button" onclick="increase()"><span>+</span></button>
                    </div>
                    <div class="flex items-center gap-6">
                        <button
                            class="flex items-center justify-center gap-4 px-4 py-2 border-solid border-[1px] rounded-lg border-secondary"
                            type="button"
                            onclick="productAction(event, '/cart/add', {{ Auth::check() ? 'true' : 'false' }})">
                            <i class="fa-solid fa-cart-shopping text-secondary"></i>
                            <span>Add to Cart</span>
                        </button>
                        <button class="px-8 py-2 font-medium text-white rounded-lg bg-secondary" type="button"
                            onclick="productAction(event, '/products/buy', {{ Auth::check() ? 'true' : 'false' }})">Buy
                            Now</button>
                    </div>
                </form>
            </div>
        </div>
        <div>
            <h3 class="text-xl font-bold">Product Description</h3>
            <p>{{ $product->description }}</p>
        </div>
    </div>

    <script>
        function increase() {
            var input = document.getElementById('quantity');
            var value = parseInt(input.value, 10);
            input.value = isNaN(value) ? 0 : value + 1;
        }

        function decrease() {
            var input = document.getElementById('quantity');
            var value = parseInt(input.value, 10);
            if (value > 1) {
                input.value = value - 1;
            }
        }

        function productAction(event, action, isAuthenticated) {
            event.preventDefault();
            if (isAuthenticated) {
                var form = document.getElementById('productForm');
                form.action = action;
                form.submit();
            } else {
                window.location.href = "{{ route('login') }}";
            }
        }
    </script>
@endsection
