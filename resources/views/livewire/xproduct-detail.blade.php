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

      @if ($product->image)
    <div class='container mx-auto' x-data="{ showModal: false, selectedImage: '{{ $product->image[0] }}' }">
        <!-- Main Image -->
        @else
    <div class='container mx-auto' x-data="{ showModal: false, selectedImage: '{{ asset('storage/' . 'defaultImage.jpg') }}' }">
        @endif
        <div class=" w-4/5 mx-auto overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">

            <img x-bind:src="selectedImage.includes('://') ? selectedImage : '{{ asset('storage/') }}/' + selectedImage"
                alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
        </div>

        <!-- Gallery Thumbnails -->
        <div class="grid grid-flow-col gap-4 mt-4 justify-center w-3/5 mx-auto">
            @if ($product->image && count($product->image) > 0)
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
            @endif
        </div>
        <p class="mb-4">Rating: {{ $rating }}</p>
        @for ($i = 0; $i < $rating; $i++)
            ⭐️
        @endfor
        <h2 class="text-2xl font-bold mb-4">{{ $product->name }}</h2>

        <p class="mb-4">Description: {!! $product->description !!}</p>
        <p class="mb-4 font-bold text-3xl">Price: ${{ $product->price }}</p>

        @if (Auth::check())
        <!-- Add to cart button -->
        <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })" class="btn-primary btn">Add to
            Cart</button>

            @else
            <div class="lg:tooltip" data-tip="Login to add to cart">
                <button class="disabled btn">Add to Cart</button>
              </div>
        @endif
    </div>


    <!-- :product="$product" -->
 
    <livewire:Review :productId="$product->id" />
   
   {{-- new layout goes here --}}
   {{-- <section class="text-gray-600 body-font overflow-hidden">
  <div class="container px-5 py-24 mx-auto">
    <div class="lg:w-4/5 mx-auto flex flex-wrap">
       @if ($product->image)
    <div class='container mx-auto' x-data="{ showModal: false, selectedImage: '{{ $product->image[0] }}' }">
        <!-- Main Image -->
        @else
    <div class='container mx-auto' x-data="{ showModal: false, selectedImage: '{{ asset('storage/' . 'defaultImage.jpg') }}' }">
        @endif
        <div class=" w-4/5 mx-auto overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">

            <img x-bind:src="selectedImage.includes('://') ? selectedImage : '{{ asset('storage/') }}/' + selectedImage"
                alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
        </div>

        <!-- Gallery Thumbnails -->
        <div class="grid grid-flow-col gap-4 mt-4 justify-center w-3/5 mx-auto">
            @if ($product->image && count($product->image) > 0)
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
            @endif
        </div>

      <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
        <h2 class="text-sm title-font text-gray-500 tracking-widest">BRAND NAME</h2>
        <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">The Catcher in the Rye</h1>
        <div class="flex mb-4">
          <span class="flex items-center">
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24">
              <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"></path>
            </svg>
            <span class="text-gray-600 ml-3">4 Reviews</span>
          </span>
          <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">
            <a class="text-gray-500">
              <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z"></path>
              </svg>
            </a>
            <a class="text-gray-500">
              <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M23 3a10.9 10.9 0 01-3.14 1.53 4.48 4.48 0 00-7.86 3v1A10.66 10.66 0 013 4s-4 9 5 13a11.64 11.64 0 01-7 2c9 5 20 0 20-11.5a4.5 4.5 0 00-.08-.83A7.72 7.72 0 0023 3z"></path>
              </svg>
            </a>
            <a class="text-gray-500">
              <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                <path d="M21 11.5a8.38 8.38 0 01-.9 3.8 8.5 8.5 0 01-7.6 4.7 8.38 8.38 0 01-3.8-.9L3 21l1.9-5.7a8.38 8.38 0 01-.9-3.8 8.5 8.5 0 014.7-7.6 8.38 8.38 0 013.8-.9h.5a8.48 8.48 0 018 8v.5z"></path>
              </svg>
            </a>
          </span>
        </div>
        <p class="leading-relaxed">Fam locavore kickstarter distillery. Mixtape chillwave tumeric sriracha taximy chia microdosing tilde DIY. XOXO fam indxgo juiceramps cornhole raw denim forage brooklyn. Everyday carry +1 seitan poutine tumeric. Gastropub blue bottle austin listicle pour-over, neutra jean shorts keytar banjo tattooed umami cardigan.</p>
        <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
          <div class="flex">
            <span class="mr-3">Color</span>
            <button class="border-2 border-gray-300 rounded-full w-6 h-6 focus:outline-none"></button>
            <button class="border-2 border-gray-300 ml-1 bg-gray-700 rounded-full w-6 h-6 focus:outline-none"></button>
            <button class="border-2 border-gray-300 ml-1 bg-indigo-500 rounded-full w-6 h-6 focus:outline-none"></button>
          </div>
          <div class="flex ml-6 items-center">
            <span class="mr-3">Size</span>
            <div class="relative">
              <select class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                <option>SM</option>
                <option>M</option>
                <option>L</option>
                <option>XL</option>
              </select>
              <span class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                  <path d="M6 9l6 6 6-6"></path>
                </svg>
              </span>
            </div>
          </div>
        </div>
        <div class="flex">
          <span class="title-font font-medium text-2xl text-gray-900">$58.00</span>
          <button class="flex ml-auto text-white bg-indigo-500 border-0 py-2 px-6 focus:outline-none hover:bg-indigo-600 rounded">Button</button>
          <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center text-gray-500 ml-4">
            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
              <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
            </svg>
          </button>
        </div>
      </div>
    </div>
  </div>
</section> --}}
</div>
