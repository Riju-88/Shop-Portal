<div class="container mx-auto p-4">
    {{-- order list --}}
    {{-- if there are orders --}}
    @if (count($orders) > 0)
        @foreach ($orders as $order)
            {{-- order cards --}}
            <div class="bg-white shadow-md rounded-lg p-6 mb-4">
                <div class="flex justify-between items-center mb-4">
                    {{-- order number --}}
                    <div>
                        <p class="text-gray-600 text-sm">Order Number</p>
                        <p class="text-gray-800 font-semibold">{{ $order->order_number }}</p>
                    </div>
                    <div class="text-right">
                        {{-- order status --}}
                        <p class="text-gray-600 text-sm">Status</p>
                        <p class="{{ $order->status === 'delivered' ? 'text-green-500' : ($order->status === 'cancelled' ? 'text-red-500' : 'text-amber-500') }} font-semibold">{{ ucfirst($order->status) }}</p>
                    </div>
                    
                </div>
                <div class="border-t border-gray-200"></div>
                <div class="flex justify-between items-center mb-4 mt-4">
                    <div>
                        <p class="text-gray-600 text-sm">Date placed</p>
                        <p class="text-gray-800 font-semibold">{{ $order->created_at->format('Y-m-d H:i:s') }}</p>
                    </div>
                    <div class="text-right">
                        <p class="text-gray-600 text-sm">Total amount</p>
                        <p class="text-gray-800 font-semibold">${{ $order->total_amount }}</p>
                    </div>
                </div>
                <div class="border-t border-gray-200"></div>
                <div class="my-4">
                    @foreach (json_decode($order->items) as $item)
                        @php
                            $product = $products->find($item->product_id);
                            $imageArray = is_array($product->image) ? $product->image : json_decode($product->image, true);
                            $imagePath = $imageArray[0] ?? 'https://via.placeholder.com/64';
                        @endphp
                        <div class="flex items-center my-4">
                            <img class="h-16 w-16 object-cover rounded-md" src="{{ asset($imagePath) }}" alt="Product Image">
                            <div class="ml-4">
                                <p class="text-gray-800 font-semibold">{{ $product->name }}</p>
                                <div class="flex items-center justify-between mt-2">
                                    <p class="text-gray-600 text-sm">${{ $product->price }}</p>
                                    <p class="text-gray-600 text-sm">Quantity: {{ $item->quantity }}</p>
                                </div>
                            </div>
                        </div>
                        <div class="border-t border-gray-200"></div>
                    @endforeach
                </div>
                <div class="mt-4 flex justify-between items-center">
                    <div class="text-sm">
                        <p class="text-gray-600">Payment Status</p>
                        <p class="{{ $order->payment_status === 'paid' ? 'text-green-500' : 'text-amber-500' }} font-semibold">{{ ucfirst($order->payment_status) }}</p>
                    </div>
                    <div class="text-sm">
                        <p class="text-gray-600">Payment Method</p>
                        <p class="text-gray-800 font-semibold">{{ $order->payment_method }}</p>
                    </div>
                    {{-- Cancel order --}}
                    <button wire:click="cancelOrder({{ $order->id }})" class="btn btn-error btn-outline btn-sm rounded-lg">Cancel Order</button>
                </div>
            </div>
        @endforeach
    @else
        <div class="bg-white shadow-md rounded-lg p-6 text-center">
            <p class="text-gray-800 font-semibold">No orders found</p>
        </div>
    @endif
</div>