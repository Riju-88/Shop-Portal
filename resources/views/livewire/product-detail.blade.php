<div>
  
     
      <!-- product-detail.blade.php -->
      <!-- Cart Modal Structure -->

      {{-- <livewire:ShoppingCart /> --}}
      <!-- end Cart Modal Structure -->
      <div class="text-sm breadcrumbs mx-6">
        <ul>
          <li><a href="{{ route('home') }}">Home</a></li> 
          <li><a href="{{ route('productList') }}">Products</a></li> 
          <li>{{ $product->name }}</li>
        </ul>
      </div>

        <livewire:notifications />

  {{-- new layout goes here --}}
  <section class="text-gray-600 body-font">
      <div class="container px-5 py-10 mx-auto">
        <div class="lg:w-4/5 mx-auto flex flex-wrap">
            <div class="lg:w-1/2 w-full lg:h-auto ">
                @if ($product->image)
                <div class='mx-auto' x-data="{ showModal: false, selectedImage: '{{ $product->image[0] }}' }">
                    @else
                    <div class='' x-data="{ showModal: false, selectedImage: '{{ asset('storage/' . 'defaultImage.jpg') }}' }">
                        @endif
                        {{-- Main Image --}}
                        <div class="">
                            <img x-bind:src="selectedImage.includes('://') ? selectedImage : '{{ asset('storage/') }}/' + selectedImage"
                                alt="{{ $product->name }}" class="rounded-lg mx-auto object-fill h-96">
                        </div>
                        <!-- Gallery Thumbnails -->
                        <div class="flex justify-center items-center w-full h-32 my-4">
                            @if ($product->image && count($product->image) > 0)
                            @foreach ($product->image as $image)
                            
                              
                                @if (filter_var($image, FILTER_VALIDATE_URL))
                              <div x-on:click="selectedImage = '{{ $image }}'" class="cursor-pointer mx-1" >
                                  <img src="{{ $image }}" alt="Thumbnail Image" class="rounded-lg" >
                              </div>
                              @else
                              <div x-on:click="selectedImage = '{{ asset('storage/' . $image) }}'" class="cursor-pointer mx-1" >
                                  <img src="{{ asset('storage/' . $image) }}" alt="Thumbnail Image" class="rounded-lg object-fill h-32 w-32" >
                              </div>
                              @endif
                             
                            
                            @endforeach
                            @endif
                        </div>
                    </div>
                </div>
    
                <div class="lg:w-1/2 w-full lg:pl-10 lg:py-6 mt-6 lg:mt-0">
                    <h2 class="text-sm title-font text-gray-500 tracking-widest">{{ $product->brand }}</h2>
                    <h1 class="text-gray-900 text-3xl title-font font-medium mb-1">{{ $product->name }}</h1>
                    <div class="flex mb-4">
                        <span class="flex items-center">
                            @for ($i = 0; $i < $rating; $i++)
                            <svg fill="currentColor" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" class="w-4 h-4 text-indigo-500" viewBox="0 0 24 24" wire:key="star-{{ $i }}">
                                <path
                                    d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z" wire:key="star-path-{{ $i }}">
                                </path>
                            </svg>
                            @endfor
                            <span class="text-gray-600 ml-3">{{ count($product->reviews) }} Reviews</span>
                        </span>
                        <span class="flex ml-3 pl-3 py-2 border-l-2 border-gray-200 space-x-2s">
                            <a class="text-gray-500">
                                <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    class="w-5 h-5" viewBox="0 0 24 24">
                                    <path
                                        d="M18 2h-3a5 5 0 00-5 5v3H7v4h3v8h4v-8h3l1-4h-4V7a1 1 0 011-1h3z">
                                    </path>
                                </svg>
                            </a>
                            
                        </span>
                    </div>
                    <p class="leading-relaxed">{!! $product->description !!}</p>
                    {{-- Attributes --}}
                    {{-- <div class="flex mt-6 items-center pb-5 border-b-2 border-gray-100 mb-5">
                        <div class="flex">
                            <span class="mr-3">Attributes</span>
                            <button class="border-2 border-gray-300 rounded-full w-6 h-6 focus:outline-none"></button>
                            <button class="border-2 border-gray-300 ml-1 bg-gray-700 rounded-full w-6 h-6 focus:outline-none"></button>
                            <button class="border-2 border-gray-300 ml-1 bg-indigo-500 rounded-full w-6 h-6 focus:outline-none"></button>
                        </div>
                        <div class="flex ml-6 items-center">
                            <span class="mr-3">Size</span>
                            <div class="relative">
                                <select
                                    class="rounded border appearance-none border-gray-300 py-2 focus:outline-none focus:ring-2 focus:ring-indigo-200 focus:border-indigo-500 text-base pl-3 pr-10">
                                    <option>SM</option>
                                    <option>M</option>
                                    <option>L</option>
                                    <option>XL</option>
                                </select>
                                <span
                                    class="absolute right-0 top-0 h-full w-10 text-center text-gray-600 pointer-events-none flex items-center justify-center">
                                    <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                        stroke-width="2" class="w-4 h-4" viewBox="0 0 24 24">
                                        <path d="M6 9l6 6 6-6"></path>
                                    </svg>
                                </span>
                            </div>
                        </div>
                    </div> --}}
                    <div class="flex items-center gap-3 my-4">
                        <span class="title-font font-medium text-2xl text-gray-900">Rs. {{ $product->price }}</span>
                        @if (Auth::check())
                        <!-- Add to cart button -->
                        <div x-data="{ isLargeScreen: window.innerWidth > 600 }" x-on:resize.window="isLargeScreen = window.innerWidth > 600">
                            <div x-show="isLargeScreen">
                                <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })"
                                    class="btn-primary btn">Add to
                                    Cart</button>
                            </div>
          
                            <div x-show="!isLargeScreen">
                              {{--  --}}
                              <button @click="$dispatch('add-To-Cart-Mobile', { id: {{ $product->id }} })"
                                class="btn-accent btn">Add to
                                Cart</button>
                              {{--  --}}
                            </div>
                          </div>
                        @else
                        <div class="lg:tooltip" data-tip="Login to add to cart">
                            <button class="disabled btn">Add to Cart</button>
                        </div>
                        @endif
                        @auth
                        {{-- Wishlist --}}
                        <button
                        class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center ml-auto text-gray-500 hover:bg-green-200 hover:text-green-500 
                        @if($this->wishlist->contains('product_id', $product->id)) bg-green-200 text-green-500 hover:bg-red-200 hover:text-red-500 @else bg-gray-200 text-gray-500 hover:bg-green-200 hover:text-green-500 
                        @endif" @click="$dispatch('add-to-wishlist', { product_id: {{ $product->id }} })">
                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                class="w-5 h-5" viewBox="0 0 24 24">
                                <path
                                    d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                                </path>
                            </svg>
                        </button>
                        @endauth

                        
                    </div>
                    {{-- product attributes --}}
                    @if($product->attributes->isNotEmpty())
                    <h3 class="title-font font-medium text-lg text-gray-900">Product Details</h3>
                    <ul>
                        @foreach($product->attributes as $attribute)
                            <li>{{ $attribute->name }}: {{ $attribute->value }}</li>
                        @endforeach
                    </ul>
                @else
                    <p>No additional details available for this product.</p>
                @endif
                    {{--  --}}
                </div>
            </div>
        </div>
        {{-- fit reviews here --}}
        <livewire:Review :productId="$product->id" />
        
      </div>
  
  </section>

 



</div>