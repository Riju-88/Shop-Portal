<!--  -->

<div class="bg-white">

    <!-- filter -->
    <div x-data="{ open: false }" class="container">
        <div class="w-full flex justify-end">

            <button @click="open = !open" class="p-2 mx-2 rounded-full border lg:tooltip lg:tooltip-left"
                :class="open ? 'border-emerald-400 bg-emerald-400' : 'border-emerald-400'" data-tip="Filters">

                <span :class="open ? 'text-white' : 'text-emerald-400'">
                    <!-- First SVG -->
                    <svg x-show="!open" class="h-10 w-10" width="24" height="24" viewBox="0 0 24 24"
                        stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path stroke="none" d="M0 0h24v24H0z" />
                        <circle cx="14" cy="6" r="2" />
                        <line x1="4" y1="6" x2="12" y2="6" />
                        <line x1="16" y1="6" x2="20" y2="6" />
                        <circle cx="8" cy="12" r="2" />
                        <line x1="4" y1="12" x2="6" y2="12" />
                        <line x1="10" y1="12" x2="20" y2="12" />
                        <circle cx="17" cy="18" r="2" />
                        <line x1="4" y1="18" x2="15" y2="18" />
                        <line x1="19" y1="18" x2="20" y2="18" />
                    </svg>
                    <!-- Second SVG -->
                    <svg x-show="open" class="h-10 w-10 " fill="currentColor" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>

                </span>

            </button>


        </div>


        <div x-show="open" class=" my-2 inset-x-4 p-4 bg-white absolute border-2 border-emerald-500 rounded-2xl z-50" x-transition>
            <!-- Price Range -->
            <div>
                <h2 class="font-bold text-lg">Price Range</h2>
                <select wire:model.defer="selectedPriceRange" class="w-full accent-emerald-400">
                    <option value="">Select Price Range</option>
                    @foreach ($priceRangeOptions as $option)
                        <option value="{{ json_encode($option['range']) }}">{{ $option['label'] }}</option>
                    @endforeach
                </select>
            </div>
            
            

            <!-- Separator -->
            <hr />

            <!-- Categories -->
            <div>
                <h2 class="font-bold text-lg">Categories</h2>
                @foreach ($categories as $category)
                    <div>
                        <label>
                            <input type="checkbox" value="{{ $category->name }}" wire:model="selectedCategories">
                            {{ $category->name }}
                        </label>
                    </div>
                @endforeach
            </div>

            <!-- Apply Filters Button -->
            <button wire:click="applyFilters" class="btn bg-emerald-400 text-white mt-4">Apply Filters</button>
            {{-- if filter is applied then show clear button --}}
            @if ($selectedCategories || $selectedPriceRange)
                <button wire:click="clearFilters" class="btn bg-red-400 text-white mt-4">Clear Filters</button>
            @endif
        </div>
    </div>


    <!--  -->

    <div class="container flex items-center gap-2 mx-auto my-2">
        <h2 class="font-bold text-blue-500 text-2xl"><a href="{{ route('productList') }}" class="link">Products</a>
        </h2>
        <h2 class="font-bold text-emerald-500 text-2xl"><a href="/admin" class="link">Admin Panel</a>
        </h2>
    </div>
    <!--  -->
    <!-- Cart Modal Structure -->
    {{-- <livewire:ShoppingCart /> --}}
    {{-- end Cart Modal Structure --}}
    <livewire:notifications />

    <!-- product-list -->
    <div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
        <h2 class="text-2xl font-bold tracking-tight text-gray-900">Products</h2>


        <div class="mt-6 grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 xl:gap-x-8">
            @forelse($products as $index => $product)

                <div class="group relative" wire:key="{{ $product->id }}">
                    <div
                        class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                        @if (!empty($product->image) && is_array($product->image) && isset($product->image[0]))
                            @if (filter_var($product->image[0], FILTER_VALIDATE_URL))
                                <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                                    <img src="{{ $product->image[0] }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                                </a>
                            @else
                                <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                                    <img src="{{ asset('storage/' . $product->image[0]) }}" alt="{{ $product->name }}"
                                        class="h-full w-full object-cover object-center lg:h-full lg:w-full">
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
                                {{-- <p class="text-xl font-extrabold text-gray-900">
                                    {{ $product->reviews->avg('rating') }}
                                </p> --}}


                                @for ($i = 0; $i < $product->reviews->avg('rating'); $i++)
                                    ⭐️
                                @endfor
                            @else
                                <p>No ratings yet.</p>
                            @endif
                            <!--  -->
                        </div>
                        <div class="flex flex-col">
                        <p class="text-xl font-extrabold text-gray-900"> ${{ $product->price }}</p>
                       
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
                        <!-- ProductList view -->
                    </div>


                    <!-- Link to product detail page -->
                    <div class="mt-4 flex justify-between">
                        <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                            <button class="btn-secondary btn">View Details</button></a>

                            @if (Auth::check())
                        <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })"
                            class="btn-primary btn">Add to
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
        @if ($products->count() >= $on_page)
            <div x-intersect.full="$wire.loadMore()" class="p-4">
                <div wire:loading wire:target="loadMore"
                    class="bg-white dark:bg-gray-900 rounded w-full flex items-center justify-center">
                    <div class="text-gray-600 dark:text-gray-400">
                        Loading more products...
                    </div>
                </div>
            </div>
        @endif
    </div>
</div>
