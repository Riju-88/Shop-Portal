<!-- product-list -->
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $category->name }}</h2>


    <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
        @forelse($products as $index => $product)

        <div class="group relative rounded-xl shadow-xl p-2" wire:key="showcase-{{ $product->id }}">
            <div
                class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-base-100 lg:aspect-none group-hover:opacity-75 lg:h-80">
                @if (!empty($product->image) && is_array($product->image) && isset($product->image[0]))
                    @if (filter_var($product->image[0], FILTER_VALIDATE_URL))
                        <a href="{{ route('product.detail', ['productId' => $product->id]) }}" wire:navigate>
                            <img src="{{ $product->image[0] }}" alt="{{ $product->name }}"
                                class="h-full w-full object-contain object-center lg:h-full lg:w-full">
                        </a>
                    @else
                        <a href="{{ route('product.detail', ['productId' => $product->id]) }}" wire:navigate>
                            <img src="{{ asset('storage/' . $product->image[0]) }}" alt="{{ $product->name }}"
                                class="h-full w-full object-contain object-center lg:h-full lg:w-full">
                        </a>
                    @endif
                @endif
            </div>
            <div class="mt-4 flex justify-between">
                <div>
                    <h3 class="text-sm text-gray-700">
                        <!-- <a href="#"> -->
                        <!-- <span aria-hidden="true" class="absolute inset-0"></span> -->
                        {{ $product->name }}
                        <!-- </a> -->
                    </h3>
                    <div class="mt-1 text-sm text-gray-500 line-clamp-1 overflow-clip"> {!! $product->description !!}</div>
                    <!--  -->
                    
                    @if ($product->reviews->isNotEmpty())
                       
                        @for ($i = 0; $i < $product->reviews->avg('rating'); $i++)
                            ⭐️
                        @endfor
                    @else
                        <p>No ratings yet.</p>
                    @endif
                    <!--  -->
                </div>
                <div class="flex flex-col">
                <p class="text-lg font-bold text-gray-600">{{ $product->price }}</p>
               
                    @auth
                {{-- Wishlist --}}
                <button
                    class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center ml-auto text-gray-500 hover:bg-green-200 hover:text-green-500 
                    @if($this->wishlist->contains('product_id', $product->id)) bg-green-200 text-green-500 hover:bg-red-200 hover:text-red-500 @else bg-gray-200 text-gray-500 hover:bg-green-200 hover:text-green-500 
                    @endif" @mobile @click="$dispatch('wishlist-add-category', { product_id: {{ $product->id }} })" @endmobile @desktop @click="$dispatch('wishlist-add-category', { product_id: {{ $product->id }} })" @enddesktop>
                    <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        class="w-5 h-5" viewBox="0 0 24 24">
                        <path
                            d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z">
                        </path>
                    </svg>
                </button>
                @endauth
                </div>
                <!-- ProductList view -->
            </div>


            <!-- Link to product detail page -->
            <div class="mt-4 flex justify-between">
                <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                    <button class="btn-secondary btn">View Details</button></a>

                    @if (Auth::check())
                  
                            <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })"
                                class="btn-accent btn">Add to
                                Cart</button>
                      
                    @else
                    <div class="lg:tooltip" data-tip="Login to add to cart">
                        <button class="disabled btn">Add to Cart</button>
                      </div>
                @endif
            </div>
        </div>

        <!-- More products... -->
        @empty


            <div class="group relative">
                <h2 class="text-2xl font-bold tracking-tight text-gray-900">No Products Found</h2>
            </div>

        @endforelse
    </div>
    <!--  -->
    <livewire:notifications />
    <!--  -->
</div>
