<div>
   
    <div class="overflow-hidden">
        <div class="flex overflow-x-auto gap-3">
            @foreach($products as $product)
            {{-- old layout --}}
                <div class="flex-shrink-0 w-64 mx-3 mb-3 p-3 shadow-xl rounded-2xl gap-1"
             wire:key="mobile-{{ $product->id }}">
                    <div class=" shadow-xl rounded-2xl overflow-hidden">
                       
                                @if (!empty($product->image) && is_array($product->image) && isset($product->image[0]))
                                    @if (filter_var($product->image[0], FILTER_VALIDATE_URL))
                                        <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                                            <img src="{{ $product->image[0] }}" alt="{{ $product->name }}" class="min-h-52 w-full object-contain object-center text-gray-400 flex justify-center items-center">
                                        </a>
                                    @else
                                        <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                                            <img src="{{ asset('storage/' . $product->image[0]) }}" alt="{{ $product->name }}" class="min-h-52 w-full object-contain object-center text-gray-400 flex justify-center items-center">
                                        </a>
                                    @endif
                                @else
                                    <div class="min-h-52 w-full object-cover object-center text-gray-400 flex justify-center items-center"> Image not available</div>
                                @endif
                            </div>
                            <div class="mt-4 flex justify-between">
                                <div>
                                    <h3 class="text-sm text-gray-700">{{ $product->name }}</h3>
                                    <div class="mt-1 text-sm text-gray-500 line-clamp-1 overflow-clip">{!! $product->description !!}</div>
                                    @if ($product->reviews->isNotEmpty())
                                        @for ($i = 0; $i < $product->reviews->avg('rating'); $i++)
                                            ⭐️
                                        @endfor
                                    @else
                                        <p>No ratings yet.</p>
                                    @endif
                                </div>
                                <div class="flex flex-col">
                                    <p class="text-lg font-bold text-gray-600">{{ $product->price }}</p>
                                    {{-- Wishlist --}}
                                    @auth
                                        <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center ml-auto text-gray-500  @if($this->wishlist->contains('product_id', $product->id)) bg-green-200 text-green-500 @else bg-gray-200 text-gray-500  @endif" @click="$dispatch('wishlist-add-mobile', { product_id: {{ $product->id }} })">
                                            <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                                <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                                            </svg>
                                        </button>
                                    @endauth
                                </div>
                            </div>
                            <div class="mt-4 flex mx-2 justify-center flex-wrap gap-2">
                                <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                                    <button class="btn-accent btn btn-outline @mobile btn-wide @endmobile  ">View Details</button>
                                </a>
                                @if (Auth::check())
                                    <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })" class="btn-accent btn @mobile btn-wide @endmobile ">Add to Cart</button>
                                @else
                                    <div class="lg:tooltip" data-tip="Login to add to cart">
                                        <button class="disabled btn @mobile btn-wide @endmobile ">Add to Cart</button>
                                    </div>
                                @endif
                            </div>
                        </div>
                {{-- old layout --}}
            @endforeach
        </div>
    </div>
    
</div>
