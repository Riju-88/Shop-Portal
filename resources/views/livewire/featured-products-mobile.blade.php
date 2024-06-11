<div>
   
    <div class="overflow-hidden">
        <div class="flex overflow-x-auto">
            @foreach($products as $product)
                <div class="flex-shrink-0 w-64 mx-4">
                    <div class="bg-white shadow-xl rounded-2xl overflow-hidden">
                        @if (!empty($product->image) && is_array($product->image) && isset($product->image[0]))
                            @if (filter_var($product->image[0], FILTER_VALIDATE_URL))
                                <img src="{{ $product->image[0] }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                            @else
                                <img src="{{ asset('storage/' . $product->image[0]) }}" alt="{{ $product->name }}" class="w-full h-40 object-cover">
                            @endif
                        @else
                            <div class="w-full h-40 bg-gray-200"></div>
                        @endif
                        <div class="p-4">
                            <h3 class="text-gray-900 font-semibold text-lg mb-2">{{ $product->name }}</h3>
                            <p class="text-gray-700 mb-2 line-clamp-1 overflow-clip">{!! $product->description !!}</p>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-900 font-bold">${{ $product->price }}</span>
                                <button class="text-white bg-blue-500 px-4 py-2 rounded-md hover:bg-blue-600">Add to Cart</button>
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    
</div>
