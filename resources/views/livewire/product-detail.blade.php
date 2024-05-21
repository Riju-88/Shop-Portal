<div>

    <div class="container flex items-center gap-2 mx-auto my-2">
        <h2 class="font-bold text-blue-500 text-2xl"><a href="{{ route('productList') }}" class="link">Products</a>
        </h2>
        <h2 class="font-bold text-emerald-500 text-2xl"><a href="/admin" class="link">Admin Panel</a>
        </h2>
    </div>
    <!-- product-detail.blade.php -->
    <!-- Cart Modal Structure -->
    {{-- <livewire:ShoppingCart /> --}}
    <!-- end Cart Modal Structure -->
    <div class="text-sm breadcrumbs">
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li> 
          <li><a href="{{ route('productList') }}">Products</a></li> 
          <li>{{ $product->name }}</li>
        </ul>
      </div>
    <div class='container mx-auto' x-data="{ showModal: false, selectedImage: '{{ $product->image[0] }}' }">
        <!-- Main Image -->

        <div class=" w-4/5 mx-auto overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">

            <img x-bind:src="selectedImage.includes('://') ? selectedImage : '{{ asset('storage/') }}/' + selectedImage"
                alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
        </div>

        <!-- Gallery Thumbnails -->
        <div class="grid grid-flow-col gap-4 mt-4 justify-center w-3/5 mx-auto">
            @foreach ($product->image as $image)
                @if (filter_var($image, FILTER_VALIDATE_URL))
                    <div x-on:click="selectedImage = '{{ $image }}'" class="cursor-pointer">

                        <img src="{{ $image }}" alt="Thumbnail Image" class="w-full h-auto">
                    </div>
                @else
                    <div x-on:click="selectedImage = '{{ asset('storage/' . $image) }}'" class="cursor-pointer">
                        <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail Image" class="w-full h-auto">
                    </div>
                @endif
            @endforeach
        </div>
        <p class="mb-4">Rating: {{ $rating }}</p>
        @for ($i = 0; $i < $rating; $i++)
            ⭐️
        @endfor
        <h2 class="text-2xl font-bold mb-4">{{ $product->name }}</h2>

        <p class="mb-4">Description: {{ $product->description }}</p>
        <p class="mb-4 font-bold text-3xl">Price: ${{ $product->price }}</p>

        <!-- Add to cart button -->
        <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })" class="btn-primary btn">Add to
            Cart</button>
    </div>


    <!-- :product="$product" -->
    <livewire:Review :productId="$product->id" :userId="Auth::user()->id" />

</div>
