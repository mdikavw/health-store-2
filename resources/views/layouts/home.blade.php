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
        <nav class="w-full">
            @include('partials.navbar')
        </nav>

        <main class="container flex-grow w-full">
            @yield('content')
        </main>

        <footer class="w-full">
            @include('partials.footer')
        </footer>
    </body>

</html>
