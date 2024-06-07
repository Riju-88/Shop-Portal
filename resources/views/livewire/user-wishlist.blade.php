

<div x-data="{ showModal: false }"  @toggle-cart.window="showModal = !showModal" class="relative  ">
   
   
       
         <button @click="showModal = true" class=" px-2 text-accent rounded-md">
       Wishlist</button>
 
   
    {{-- heroicon-o-shopping-bag --}}
    <div x-show="showModal" x-transition:enter="transition ease-in-out duration-500 transform"
        x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition linear duration-500 transform" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed z-50 overflow-y-scroll flex justify-center items-center  inset-0 w-full h-full bg-opacity-30 bg-black no-scrollbar">
        <div class="fixed top-0 bottom-0 left-auto right-auto h-screen overflow-y-scroll bg-opacity-30 bg-white before:content-['*'] before:h-screen before:w-screen before:bg-white before:absolute before:inset-0 before:z-[-1] no-scrollbar">
            <!-- Stop the click event propagation to prevent it from closing the modal -->
            {{--  --}}

            {{-- test --}}
            <div class="container overflow-hidden flex ">
                <div class="flex flex-col justify-between md:w-full w-3/4 mx-auto   p-4 bg-white  shadow-md"
                    @click.away="showModal = false">
                    <h2 class="text-2xl font-extrabold tracking-tight text-center mb-4">Wishlist</h2>
                    <div class="flex flex-col space-y-4 overflow-y-scroll no-scrollbar">
                      
                        <div class="container mx-auto my-8 p-4">
                            @forelse ($wishlist as $item)
                              <div class="bg-white shadow-md rounded-lg p-6 mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-center" wire:key="wishlist-{{ $item->id }}">
                                <div class="col-span-2 md:col-span-1 flex justify-center">
                                  @if($item->product->image)
                                    @if (filter_var($item->product->image[0], FILTER_VALIDATE_URL))
                                    <a href="{{ route('product.detail', ['productId' => $item->product->id]) }}" wire:navigate> <img src="{{ $item->product->image[0] }}" class="h-24 w-24 object-cover rounded-xl border-2 border-amber-400"></a>
                                     
                                    @else
                                    <a href="{{ route('product.detail', ['productId' => $item->product->id]) }}" wire:navigate> <img src="{{ asset('storage/' . $item->product->image[0] ) }}" class="h-24 w-24 object-cover rounded-xl border-2 border-amber-400"></a>
                                   
                                    @endif
                                  @else
                                  <a href="{{ route('product.detail', ['productId' => $item->product->id]) }}" wire:navigate>  <div class="h-24 w-24 bg-gray-200 rounded-full border-2 border-amber-400"></div></a>
                                  
                                  @endif
                                </div>
                                <div class="col-span-2">
                                  <div class="text-xl font-semibold text-amber-600"><a href="{{ route('product.detail', ['productId' => $item->product->id]) }}" wire:navigate>{{ $item->product->name }}</a></div>
                                  <div class="text-sm text-gray-600">{!! $item->product->description !!}</div>
                                </div>
                                <div class="flex flex-col items-start md:items-center">
                                  <div class="text-lg text-amber-600">{{ $item->product->price }}</div>
                                  @if($item->product && $item->product->categories->isNotEmpty())
                                        {{ $item->product->categories->first()->name }}
                                    @else
                                        No category available
                                    @endif
                                </div>
                                <div class="text-center">
                                  
                                  <button class="p-1 border-2 border-error rounded-full text-error hover:bg-error hover:text-white" x-transition  @click="$dispatch('remove-from-wishlist', { product_id: {{ $item->product->id }} })" title="Remove from wishlist" >
                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                    
                                </button>
                                </div>
                              </div>
                            @empty
                              <div class="bg-white shadow-md rounded-lg p-6 mb-6 text-center">
                                <p class="text-amber-600">No items in wishlist</p>
                              </div>
                            @endforelse
                          </div>

                    </div>
                    
                    
                </div>

            </div>

           
        </div>
    </div>

</div>
