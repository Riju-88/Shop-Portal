<div class="container h-screen my-2">
<div class="flex flex-col justify-between md:w-full w-3/4 mx-auto  my-4 p-4 bg-slate-200 rounded-lg shadow-md" @click.away="showModal = false">
    <h1 class="text-2xl font-bold mb-4">Cart Items</h1>
    <div class="flex flex-col space-y-4 overflow-y-scroll">
        @if(count($carts) > 0)
        @foreach($carts as $index => $cartItem)
                <div class="flex flex-col md:flex-row items-start md:space-x-4 space-y-4 md:space-y-0 bg-slate-50 p-4 rounded-xl">
                    @if (!empty($cartItem['product']['image']) && is_array($cartItem['product']['image']) && isset($cartItem['product']['image'][0]))
                        @if (filter_var($cartItem['product']['image'][0], FILTER_VALIDATE_URL))
                            <img class="w-full md:w-24 h-24 object-cover rounded-lg" src="{{ $cartItem['product']['image'][0] }}" alt="{{ $cartItem['product']['name'] }}">
                        @else
                            <img class="w-full md:w-24 h-24 object-cover rounded-lg" src="{{ asset('storage/' . $cartItem['product']['image'][0]) }}" alt="{{ $cartItem['product']['name'] }}">
                        @endif
                    @endif
                    <div class="flex flex-col justify-between flex-grow">
                        <div>
                            <h2 class="text-lg font-bold">{{ $cartItem['product']['name'] }}</h2>
                            <p class="text-sm text-gray-700 mt-1">{!! $cartItem['product']['description'] !!}</p>
                        </div>
                        <h2 class="text-lg font-bold">Quantity</h2>
                        <div class="flex items-center justify-between mt-2">
                        
                            <div class="flex items-center space-x-2">
                                <!-- Quantity Adjustment Controls -->
                                <div class="flex items-center space-x-2">
                        <button wire:click="decrementQuantity({{ $index }})" class="px-2 py-1 bg-gray-200 rounded-l hover:bg-blue-500">-</button>
                        <input type="number" class="text-black w-2/5 rounded-lg" wire:model="carts.{{ $index }}.quantity" min="1" readonly>
                        <button wire:click="incrementQuantity({{ $index }})" class="px-3 py-1 bg-gray-200 rounded-r hover:bg-blue-500">+</button>
                    </div>
                            </div>
                            
                            <button class="p-1 hover:text-red-500" wire:click="removeItem({{ $index }})">
                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
                                </svg>
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        @else
            <p>No items in the cart.</p>
        @endif
    </div>
    <button class="mt-4 px-4 py-2 bg-blue-500 text-white rounded hover:bg-blue-600">Checkout</button>
</div>
</div>
