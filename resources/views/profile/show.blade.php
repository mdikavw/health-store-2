@extends('layouts.app')

@php
    $userData = [
        'Name' => [
            'name' => 'name',
            'value' => $user->name,
            'disabled' => false,
            'type' => 'text',
        ],
        'Username' => [
            'name' => 'username',
            'value' => $user->username,
            'disabled' => true,
            'type' => 'text',
        ],
        'E-mail' => [
            'name' => 'email',
            'value' => $user->email,
            'disabled' => true,
            'type' => 'text',
        ],
        'Phone' => [
            'name' => 'phone',
            'value' => $user->phone,
            'disabled' => false,
            'type' => 'tel',
        ],
        'Address' => [
            'name' => 'address',
            'value' => $user->address,
            'disabled' => false,
            'type' => 'text',
        ],
    ];
@endphp

@section('content')
    <div class="flex flex-col gap-8">
        <div>
            <h2 class="text-2xl font-bold">My Profile</h2>
            <span>Edit your profile</span>
        </div>
        @include('partials.session_flash')
        <form action="/profile" method="POST">
            @csrf
            @method('PATCH')
            <div class="grid gap-4">
                @foreach ($userData as $attribute => $data)
                    <div class="grid grid-cols-[150px_1fr] items-center gap-2">
                        <span>{{ $attribute }}</span>
                        @if ($data['disabled'])
                            <span>{{ $data['value'] }}</span>
                        @else
                            <input class="w-full p-2 border rounded" name="{{ $data['name'] }}" type="{{ $data['type'] }}"
                                value="{{ $data['value'] }}">
                        @endif
                    </div>
                @endforeach
            </div>
            <button class="px-4 py-2 mt-8 text-white rounded-lg bg-primary" type="submit">Edit</button>
        </form>
    </div>
@endsection
