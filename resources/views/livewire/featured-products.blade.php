<div>
    <div class="flex justify-between">
        <div class="text-2xl font-bold bg-accent px-4 py-2 tracking-tight text-gray-600 rounded-e-full">Featured Products</div>
    </div>
<div x-data="{
currentIndex: 0,
itemsToShow: 3,
productCount: {{ count($products) }},
get maxIndex() {
return Math.ceil(this.productCount / this.itemsToShow) - 1;
},
get atStart() {
return this.currentIndex === 0;
},
get atEnd() {
return this.currentIndex >= this.maxIndex;
},
prev() {
if (!this.atStart) {
this.currentIndex--;
} else {
this.currentIndex = this.maxIndex;
}
},
next() {
if (!this.atEnd) {
this.currentIndex++;
} else {
this.currentIndex = 0;
}
}
}" class="relative mb-6">
<button @click="prev" class="absolute left-0 top-1/2 transform -translate-y-1/2 z-10 bg-gray-700 text-white p-2 rounded-full">
<x-filament::icon

icon="heroicon-m-arrow-left"

class="h-5 w-5 text-white dark:text-gray-400"
/>
</button>
<div class="overflow-hidden relative">
<div class="flex transition-transform duration-300" :style="{ transform: `translateX(-${currentIndex * 100}%)` }">
@foreach($products->chunk($device == 'desktop' ? 3 : 1) as $productChunk)
  <div class="w-full flex flex-shrink-0 gap-x-6 my-4">
      @foreach($productChunk as $product)
          <div class="group relative w-full sm:w-1/2 md:w-1/3 p-2 box-border shadow-xl rounded-xl" wire:key="{{ $product->id }}">
              <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-md bg-gray-200 lg:aspect-none group-hover:opacity-75 lg:h-80">
                  @if (!empty($product->image) && is_array($product->image) && isset($product->image[0]))
                      @if (filter_var($product->image[0], FILTER_VALIDATE_URL))
                          <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                              <img src="{{ $product->image[0] }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                          </a>
                      @else
                          <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                              <img src="{{ asset('storage/' . $product->image[0]) }}" alt="{{ $product->name }}" class="h-full w-full object-cover object-center lg:h-full lg:w-full">
                          </a>
                      @endif
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
                          <button class="rounded-full w-10 h-10 bg-gray-200 p-0 border-0 inline-flex items-center justify-center ml-auto text-gray-500 hover:bg-green-200 hover:text-green-500 @if($this->wishlist->contains('product_id', $product->id)) bg-green-200 text-green-500 hover:bg-red-200 hover:text-red-500 @else bg-gray-200 text-gray-500 hover:bg-green-200 hover:text-green-500 
                            @endif" @click="$dispatch('add-to-wishlist', { product_id: {{ $product->id }} })">
                              <svg fill="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24">
                                  <path d="M20.84 4.61a5.5 5.5 0 00-7.78 0L12 5.67l-1.06-1.06a5.5 5.5 0 00-7.78 7.78l1.06 1.06L12 21.23l7.78-7.78 1.06-1.06a5.5 5.5 0 000-7.78z"></path>
                              </svg>
                          </button>
                      @endauth
                  </div>
              </div>
              <div class="mt-4 flex justify-between">
                  <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                      <button class="btn-secondary btn">View Details</button>
                  </a>
                  @if (Auth::check())
                      <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })" class="btn-primary btn">Add to Cart</button>
                  @else
                      <div class="lg:tooltip" data-tip="Login to add to cart">
                          <button class="disabled btn">Add to Cart</button>
                      </div>
                  @endif
              </div>
          </div>
      @endforeach
  </div>
@endforeach
</div>
</div>
<button @click="next" class="absolute right-0 top-1/2 transform -translate-y-1/2 z-10 bg-gray-700 text-white p-2 rounded-full">
<x-filament::icon

icon="heroicon-m-arrow-right"

class="h-5 w-5 text-white dark:text-gray-400"
/>
</button>
</div>
</div>
