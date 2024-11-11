<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>@yield('title')</title>
        <script src="https://kit.fontawesome.com/02225abd0c.js" crossorigin="anonymous"></script>
        @vite('resources/css/app.css')
    </head>

    <body class="flex flex-col min-h-screen bg-neutral">
        <nav class="fixed w-full h-16">
            @include('partials.navbar')
        </nav>
        <main class="flex min-h-screen mt-16">
            <aside class="w-[200px] bg-white fixed h-full flex flex-col gap-6 py-8">
                <a class="px-8 py-2 hover:bg-white" href="/admin/dashboard">Dashboard</a>
                <a class="px-8 py-2 hover:bg-white" href="/admin/products">Products</a>
                <a class="px-8 py-2 hover:bg-white" href="/admin/categories">Categories</a>
                <a class="px-8 py-2 hover:bg-white" href="/admin/orders">Orders</a>
                <a class="px-8 py-2 hover:bg-white" href="/admin/users">Users</a>
            </aside>
            <div class="ml-[200px] flex-grow px-10 py-8 overflow-y-auto">
                <h2 class="mb-6 text-2xl font-bold">@yield('page_title')</h2>
                @yield('content')
            </div>
        </main>
        <footer class="z-10 w-full">
            @include('partials.footer')
        </footer>
    </body>

</html>
