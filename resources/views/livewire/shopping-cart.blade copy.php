<div x-data="{ showModal: false }"  @toggle-cart.window="showModal = !showModal" class="relative z-50 ">
    {{-- cart item indicator --}}
    <div class="indicator">
        <span class="indicator-item badge badge-secondary">{{ count($carts) }}</span> 
         <button @click="showModal = true" class=" px-2  rounded-md">
        <x-filament::icon
        alias="panels::topbar.global-search.field"
        icon="heroicon-o-shopping-cart"
        
        class="h-8 w-8 text-gray-500 dark:text-gray-400"
    /></button>
    </div>
   
    {{-- heroicon-o-shopping-bag --}}
    <div x-show="showModal" x-transition:enter="transition ease-in-out duration-500 transform"
        x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
        x-transition:leave="transition linear duration-500 transform" x-transition:leave-start="opacity-100 translate-x-0"
        x-transition:leave-end="opacity-0 translate-x-full"
        class="fixed z-50 overflow-y-scroll flex justify-end  inset-0 w-full h-full bg-opacity-30 bg-black">
        <div class="fixed top-0 right-0  h-screen overflow-y-scroll bg-opacity-30 bg-black before:content-['*'] before:h-screen before:w-screen before:bg-black before:absolute before:inset-0 before:z-[-1]">
            <!-- Stop the click event propagation to prevent it from closing the modal -->
            {{--  --}}

            {{-- test --}}
            <div class="container overflow-hidden flex ">
                <div class="flex flex-col justify-between md:w-full w-3/4 mx-auto   p-4 bg-white  shadow-md"
                    @click.away="showModal = false">
                    <h2 class="text-2xl font-extrabold tracking-tight mb-4">Cart Items</h2>
                    <div class="flex flex-col space-y-4 overflow-y-scroll">
                        @if (count($carts) > 0)
                            @foreach ($carts as $index => $cartItem)
                                <div
                                    class="flex flex-col md:flex-row items-start md:space-x-4 space-y-4 md:space-y-0 bg-slate-200 border-1 p-4 rounded-xl">
                                    @if (
                                        !empty($cartItem['product']['image']) &&
                                            is_array($cartItem['product']['image']) &&
                                            isset($cartItem['product']['image'][0]))
                                        @if (filter_var($cartItem['product']['image'][0], FILTER_VALIDATE_URL))
                                            <img class="w-full md:w-24 h-24 object-cover rounded-lg"
                                                src="{{ $cartItem['product']['image'][0] }}"
                                                alt="{{ $cartItem['product']['name'] }}">
                                        @else
                                            <img class="w-full md:w-24 h-24 object-cover rounded-lg"
                                                src="{{ asset('storage/' . $cartItem['product']['image'][0]) }}"
                                                alt="{{ $cartItem['product']['name'] }}">
                                        @endif
                                    @endif
                                    <div class="flex flex-col justify-between flex-grow">
                                        <div class="flex-col">
                                            <div>
                                                <h2 class="text-lg font-bold">{{ $cartItem['product']['name'] }}</h2>
                                                {{-- <p class="text-sm text-gray-700 mt-1">{!! $cartItem['product']['description'] !!}</p> --}}
                                            </div>
                                            <h2 class="text-lg font-bold">Quantity</h2>
                                            <div class="flex items-center justify-between mt-2">

                                                <div class="flex items-center space-x-2">
                                                    <!-- Quantity Adjustment Controls -->
                                                    <div class="flex items-center space-x-2">
                                                        <button wire:click="decrementQuantity({{ $index }})"
                                                            class="px-2 py-1 bg-gray-200 rounded-l hover:bg-blue-500">-</button>
                                                        <input type="number" class="text-black w-2/5 rounded-lg"
                                                            wire:model="carts.{{ $index }}.quantity"
                                                            min="1" readonly>
                                                        <button wire:click="incrementQuantity({{ $index }})"
                                                            class="px-3 py-1 bg-gray-200 rounded-r hover:bg-blue-500">+</button>
                                                    </div>
                                                </div>

                                                <button class="p-1 hover:text-red-500"
                                                    wire:click="removeItem({{ $index }})">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            d="M6 18L18 6M6 6l12 12">
                                                        </path>
                                                    </svg>
                                                </button>
                                            </div>



                                        </div>
                                        <div class="flex-col justify-between">
                                            <p class="text-lg font-bold">{{ $cartItem['total_price'] }}</p>
                                        </div>

                                    </div>



                                </div>
                                <div class="divider"></div>
                            @endforeach

                            <!-- total amount -->
                            <div class="border-t border-gray-200 dark:border-zinc-600 py-6 px-4 sm:px-6">
                                <div class="flex justify-between">
                                    <p class="text-lg font-bold">Subtotal</p>
                                    <!-- sum of all total_price in cart -->
                                    <p class="text-lg font-bold">{{ collect($carts)->sum('total_price') }}
                                    </p>
                                </div>
                                {{-- checkout button --}}
                                <div class="flex justify-between mt-4">
                                    <a href="{{ route('checkout') }}"
                                        class="btn btn-accent btn-outline mt-4 btn-block ">Checkout</a>
                                </div>


                            </div>
                            <!--  -->
                        @else
                            <p>No items in the cart.</p>
                        @endif
                    </div>


                </div>

            </div>

            {{-- test --}}
        </div>
    </div>

</div>
