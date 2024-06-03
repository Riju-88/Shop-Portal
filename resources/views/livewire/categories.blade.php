<!-- product-list -->
<div class="mx-auto max-w-2xl px-4 py-16 sm:px-6 sm:py-24 lg:max-w-7xl lg:px-8">
    <h2 class="text-2xl font-bold tracking-tight text-gray-900">{{ $category->name }}</h2>


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
                        <div class="mt-1 text-sm text-gray-500 line-clamp-3"> {!! $product->description !!}</div>
                        <!--  -->
                        @if ($product->reviews->isNotEmpty())
                            <p class="text-xl font-extrabold text-gray-900">
                                {{ $product->reviews->avg('rating') }}
                            </p>


                            @for ($i = 0; $i < $product->reviews->avg('rating'); $i++)
                                ⭐️
                            @endfor
                        @else
                            <p>No ratings yet.</p>
                        @endif
                        <!--  -->
                    </div>

                    <p class="text-sm font-medium text-gray-900"> ${{ $product->price }}</p>
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
