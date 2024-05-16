<x-guest-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>



    <!-- <livewire:ProductList/> -->
<!-- resources/views/livewire/product-list.blade.php -->

<div class="container">
    <h1>Products</h1>
    <div class="row">
        @foreach($products as $product)
            <div class="col-md-4">
                <div class="card mb-4 shadow-sm">
                    <img class="card-img-top" src="{{ $product->image }}" alt="{{ $product->name }}">
                    <div class="card-body">
                        <h5 class="card-title text-green-600">{{ $product->name }}</h5>
                        <p class="card-text">{{ $product->description }}</p>
                        <div class="d-flex justify-content-between align-items-center">
                            <div class="btn-group">
                                <a href="{{ route('products.show', $product) }}" class="btn btn-sm btn-outline-secondary">View</a>
                                <!-- Add more buttons/actions as needed -->
                            </div>
                            <small class="text-muted">${{ $product->price }}</small>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
</div>


</x-guest-layout>