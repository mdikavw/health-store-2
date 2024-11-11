<!DOCTYPE html>
<html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Register</title>
        @vite('resources/css/app.css')
    </head>

    <body>
        <div class="flex">
            <div class="flex flex-col items-center justify-center w-1/2 h-screen gap-4 px-16 text-white bg-primary">
                {{-- some logo --}}
                <div class="w-32 h-32 bg-white rounded-full">&nbsp;</div>
                <h2 class="text-center text-bold font-xl">Welcome to Health Store</h2>
                <p class="text-center">Lorem ipsum dolor sit, amet consectetur adipisicing elit. Tempora et sequi ut,
                    laudantium possimus
                    nam minus quam itaque cupiditate laboriosam expedita sunt inventore tempore enim praesentium
                    quibusdam facere esse. Autem.</p>
            </div>
            <div class="relative flex flex-col items-center justify-center w-1/2 h-screen gap-6">
                <h2 class="text-2xl font-bold">Register</h2>
                <form class="flex flex-col w-3/5 gap-4" action="{{ url('register') }}" method="POST">
                    @csrf
                    @include('partials.auth_input', [
                        'name' => 'name',
                        'label' => 'Name',
                        'type' => 'text',
                        'placeholder' => 'Enter your name',
                    ])
                    @include('partials.auth_input', [
                        'name' => 'username',
                        'label' => 'Username',
                        'type' => 'text',
                        'placeholder' => 'Enter your username',
                    ])
                    @include('partials.auth_input', [
                        'name' => 'email',
                        'label' => 'Email',
                        'type' => 'email',
                        'placeholder' => 'Enter your email',
                    ])
                    @include('partials.auth_input', [
                        'name' => 'password',
                        'label' => 'Password',
                        'type' => 'password',
                        'placeholder' => 'Enter your password',
                    ])
                    @include('partials.auth_input', [
                        'name' => 'password_confirmation',
                        'label' => 'Confirm your password',
                        'type' => 'password',
                        'placeholder' => 'Confirm your password',
                    ])

                    <button class="px-4 py-2 my-8 text-white rounded-lg bg-primary" type="submit">Register</button>
                </form>
                <span class="absolute bottom-8">Already have an account? <a class="underline"
                        href="/login">Login</a></span>
            </div>
        </div>

    </body>

</html>
