@extends('layouts.app')

@section('page_title')
    Invoice #{{ $order->id }}
@endsection

@section('content')
    @include('partials.invoice', ['order' => $order])
    <div class="text-center">
        <button class="p-4 mt-4 text-white rounded-lg bg-primary">
            <a href="{{ route('orders.invoice_download', $order) }}" style="color: #fff;">Download PDF</a>
        </button>
    </div>
@endsection
