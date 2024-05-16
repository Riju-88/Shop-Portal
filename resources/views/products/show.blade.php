<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>


    <div class="container">
        <h1>{{ $product->name }}</h1>
        <div class="card mb-4 shadow-sm">
            <img class="card-img-top" src="{{ $product->image }}" alt="{{ $product->name }}">
            <div class="card-body">
                <h5 class="card-title">{{ $product->name }}</h5>
                <p class="card-text">{{ $product->description }}</p>
                <p class="card-text">Price: ${{ $product->price }}</p>
                <!-- Add more details as needed -->
                <a href="{{ route('products.index') }}" class="btn btn-primary">Back to Products</a>
            </div>
        </div>
    </div>


    </x-guest-layout>