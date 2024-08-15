<div>
  <div class="py-2 my-6">
         
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
             <div class=" overflow-hidden  sm:rounded-lg">
                 <!-- Carousel -->
                 {{-- if promo has image property --}}
                 @if($promo !== null && $promo->image !== null)
                 
   <div x-data="{ activeSlide: 0, slides: {{ count($promo->image) }}, nextSlide() { this.activeSlide = (this.activeSlide + 1) % this.slides }, prevSlide() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides }, startAutoSlide() { setInterval(() => { this.nextSlide() }, 5000) } }" x-init="startAutoSlide" class="carousel w-full my-6">
                  @forelse($promo->image as $index => $image)
                  <div x-show="activeSlide === {{ $index }}" class="carousel-item  w-full  relative bg-gradient-to-r  text-white overflow-hidden" style="height: 0; padding-bottom: 56.25%;"  
                  x-transition:enter="transition ease-in-out duration-500 transform"
                  x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition linear duration-500 transform" x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 translate-x-full"
                  >
                      <img src="{{ asset('storage/' . $image) }}" class="absolute top-0 left-0 w-full h-full object-cover    opacity-80" />
                      <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2 opacity-65 z-10">
                          <button @click="prevSlide" class="btn btn-circle">❮</button>
                          <button @click="nextSlide" class="btn btn-circle">❯</button>
                      </div>
                      {{-- test text --}}
                      <div class="absolute  w-full h-full flex-col lg:flex-row-reverse items-center justify-center">
                        
                        <div class="hero h-full">
                            <div class="hero-content flex-col lg:flex-row-reverse w-full">
                            
                              <div class=" rounded-lg w-full bg-opacity-50  p-4 md:p-6 backdrop-blur-sm bg-gray-200  text-zinc-700 ">
                                <a class="text-2xl md:text-6xl font-extrabold md:font-bold" href="{{ route('productList')}}" wire:navigate>{{ $promo->title }}</a>
                                <p class="py-2 md:py-4 text-pretty font-semibold">{!! $promo->description !!}</p>
                                @desktop
                                <a class="btn btn-accent rounded-full text-lg text-white justify-center" href="{{ route('productList')}}" wire:navigate>Shop Now</a>
                                @enddesktop
                              </div>
                            </div>
                          </div>
                      </div>
                      {{-- test text --}}
                  </div>
                  @empty
                  <div x-show="activeSlide === 1" class="carousel-item relative w-full" style="height: 0; padding-bottom: 56.25%;"  x-transition:enter="transition ease-in-out duration-500 transform"
                  x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition linear duration-500 transform" x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 translate-x-full">
                      <img src="https://source.unsplash.com/random/?fruit" class="absolute top-0 left-0 w-full h-full object-cover" />
                      <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                          <button @click="prevSlide" class="btn btn-circle">❮</button>
                          <button @click="nextSlide" class="btn btn-circle">❯</button>
                      </div>
                  </div>
                  @endif
              </div>
                 @endif
              
              
              {{-- device test --}}
        
                 <!-- Featured Products -->
                 <div class="flex justify-between my-4">
                  <div class="text-2xl font-bold bg-accent px-4 py-2 tracking-tight text-gray-200 rounded-e-full">Featured Products</div>
              </div>

              {{-- render featured products component based on screen size --}}
              @desktop
                 <livewire:featured-products device="desktop" />
          @enddesktop
                 
                
                    {{--  --}}
                    @mobile
                    
                  <livewire:featured-products-mobile device="mobile" />
                @endmobile
                   
                    {{--  --}}

                    {{--  --}}
                    @tablet
                    
                  <livewire:featured-products-mobile device="mobile" />
                @endtablet
                   
                    {{--  --}}
                
                </div>

             
              <!-- end of featured products -->

              <!-- product showcase -->
              <div class=" grid grid-cols-1 gap-x-2 gap-y-10 sm:grid-cols-2 lg:grid-cols-4 sm:gap-x-8 mx-8 md:mx-2">
              @forelse($productShowcase as $index => $product)

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
                                    class="h-full w-full  lg:h-full lg:w-full">
                            </a>
                        @endif
                    @endif
                </div>
                <div class="mt-4 flex justify-between">
                    <div>
                        <h3 class="text-sm font-semibold">
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
                        @endif" @mobile @click="$dispatch('wishlist-add-showcase', { product_id: {{ $product->id }} })" @endmobile @desktop @click="$dispatch('wishlist-add-showcase', { product_id: {{ $product->id }} })" @enddesktop>
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
                <div class="mt-4 flex justify-center flex-wrap gap-2">
                    <a href="{{ route('product.detail', ['productId' => $product->id]) }}">
                        <button class="btn-accent btn btn-outline @mobile btn-wide @endmobile">View Details</button></a>

                        @if (Auth::check())
                      
                                <button @click="$dispatch('add-To-Cart', { id: {{ $product->id }} })"
                                    class="btn-accent btn @mobile btn-wide @endmobile">Add to
                                    Cart</button>
                          
                        @else
                        <div class="lg:tooltip" data-tip="Login to add to cart">
                            <button class="disabled btn @mobile btn-wide @endmobile">Add to Cart</button>
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

          {{-- Browse More Products --}}
          <div class="w-full flex justify-center items-center my-4">
              <a class="font-bold  btn btn-accent btn-wide btn-outline" href="{{ route('productList') }}" wire:navigate>Browse More Products </a>
             
          </div>
                 <!--  -->
                 <livewire:notifications />
                 <!--  -->
             </div>
         </div>
     </div>
</div>