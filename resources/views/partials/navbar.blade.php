<div class="flex items-center justify-between w-full h-full px-8 py-6 text-white bg-primary">
    <div class="flex items-center gap-8">
        <div class="text-2xl font-bold">
            <h3>Health Store</h3>
        </div>
        <div>
            <ul class="flex items-center gap-6">
                <li><a href="/">Home</a></li>
                <li><a href="/products">Products</a></li>
            </ul>
        </div>
    </div>
    <div>
        @auth
            <div class="flex items-center gap-8">
                <a class="flex items-center gap-4" href="/users/{{ Auth::user()->username }}/cart">
                    <i class="text-lg text-white fa-solid fa-cart-shopping"></i>
                    <span>My Cart</span>
                </a>
                <div class="relative">
                    <div class="flex items-center gap-4 cursor-pointer" id="dropdownToggle">
                        <span>Hello, {{ explode(' ', Auth::user()->name)[0] }}</span>
                        <i class="text-xl fa-solid fa-user"></i>
                    </div>
                    <div class="absolute right-0 z-20 hidden w-48 mt-2 text-black bg-white rounded-md shadow-lg"
                        id="dropdownMenu">
                        <a class="block px-4 py-2 hover:bg-gray-100" href="{{ route('profile.show') }}">Profile</a>
                        <a class="block px-4 py-2 hover:bg-gray-100" href="{{ route('orders.index') }}">My Orders</a>
                        @if (Auth::user()->role->name === 'admin')
                            <a class="block px-4 py-2 hover:bg-gray-100" href="/admin/dashboard">Dashboard</a>
                        @endif
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button class="block w-full px-4 py-2 text-left hover:bg-gray-100" type="submit">Log
                                out</button>
                        </form>
                    </div>
                </div>
            </div>
        @else
            <div>
                <a href="{{ route('login') }}"><button class="px-4 py-2 rounded-lg bg-secondary">Log in</button></a>
            </div>
        @endauth
    </div>
</div>

<script>
    const dropdownToggle = document.getElementById('dropdownToggle');
    const dropdownMenu = document.getElementById('dropdownMenu');

    dropdownToggle.addEventListener('click', function() {
        dropdownMenu.classList.toggle('hidden');
    });

    window.addEventListener('click', function(e) {
        if (!dropdownToggle.contains(e.target) && !dropdownMenu.contains(e.target)) {
            dropdownMenu.classList.add('hidden');
        }
    });
</script>
