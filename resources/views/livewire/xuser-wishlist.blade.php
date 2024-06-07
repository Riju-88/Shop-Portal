<div>
    <button  onclick="{{ $device . '_wishlist' }}.showModal()"><a class="p-4 text-amber-600 hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in cursor-pointer">Wishlist</a></button>
<dialog id="{{ $device . '_wishlist' }}" class="modal">
  <div class="modal-box   flex bg-white/90">

    <div class="container mx-auto my-8 p-4">
        @forelse ($wishlist as $item)
          <div class="bg-white shadow-md rounded-lg p-6 mb-6 grid grid-cols-1 md:grid-cols-5 gap-4 items-center" wire:key="wishlist-{{ $item->id }}">
            <div class="col-span-2 md:col-span-1 flex justify-center">
              @if($item->product->image)
                @if (filter_var($item->product->image[0], FILTER_VALIDATE_URL))
                <a href="{{ route('product.detail', ['productId' => $item->product->id]) }}"> <img src="{{ $item->product->image[0] }}" class="h-24 w-24 object-cover rounded-xl border-2 border-amber-400"></a>
                 
                @else
                <a href="{{ route('product.detail', ['productId' => $item->product->id]) }}"> <img src="{{ asset('storage/' . $item->product->image[0] ) }}" class="h-24 w-24 object-cover rounded-xl border-2 border-amber-400"></a>
               
                @endif
              @else
              <a href="{{ route('product.detail', ['productId' => $item->product->id]) }}">  <div class="h-24 w-24 bg-gray-200 rounded-full border-2 border-amber-400"></div></a>
              
              @endif
            </div>
            <div class="col-span-2">
              <div class="text-xl font-semibold text-amber-600"><a href="{{ route('product.detail', ['productId' => $item->product->id]) }}">{{ $item->product->name }}</a></div>
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
              
              <button class="p-1 hover:text-red-500"  wire:click="removeFromWishlist({{ $item->id }})" title="Remove from wishlist" >
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke="currentColor" class="h-5 w-5">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12"></path>
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

  <form method="dialog" class="modal-backdrop ">
    <button></button>
  </form>
</dialog>
  </div>