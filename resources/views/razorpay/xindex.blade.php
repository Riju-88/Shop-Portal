<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Gateway') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-6 bg-gradient-to-r from-green-100 to-blue-100 min-h-screen flex items-center justify-center">
        <div class="bg-white shadow-lg rounded-xl p-8 max-w-2xl w-full">
            <!-- Order Summary -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold mb-6 flex items-center space-x-2 text-gray-700">
                    <x-filament::icon
               
                icon="heroicon-o-shopping-cart"
                
                class="h-8 w-8 text-accent dark:text-gray-400"
            />
                    <span>Order Summary</span>
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-gray-600">
                    <div>
                        <p><strong>Shipping Method:</strong> {{ session('formState')['shipping_method_name'] }} ({{ session('formState')['shipping_method_description'] }})</p>
                        <p><strong>Expected Delivery Time:</strong> {{ session('formState')['expected_delivery_time'] }}</p>
                        <p><strong>Shipping Cost:</strong> Rs. {{ session('formState')['shipping_cost'] }}</p>
                    </div>
                    <div>
                        <p><strong>Subtotal:</strong> Rs. {{ session('formState')['subtotal'] }}</p>
                        <p><strong>Total Discount:</strong> Rs. {{ session('formState')['total_discount'] }}</p>
                        <p><strong>Total Amount:</strong> Rs. {{ session('formState')['total_amount'] }}</p>
                    </div>
                </div>
            </div>
    
            <hr class="border-gray-300 mb-8">

              <!-- Cart Items -->
        <div class="mb-8">
            <h3 class="text-2xl font-bold mb-6 flex items-center space-x-2 text-gray-700">
                <svg class="h-8 w-8 text-green-500" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor">
                    <path d="M3 6h18v2H3V6zm0 4h18v2H3v-2zm0 4h18v2H3v-2zm0 4h18v2H3v-2z"/>
                </svg>
                <span>Cart Items</span>
            </h3>
            <div class="space-y-4">
                @foreach(session('formState')['cart_items'] as $item)
                <div class="bg-gray-100 p-4 rounded-lg flex justify-between items-center">
                    <div>
                        <p><strong>Product ID:</strong> {{ $item['product_id'] }}</p>
                        <p><strong>Quantity:</strong> {{ $item['quantity'] }}</p>
                    </div>
                    <div>
                        <p><strong>Total Price:</strong> Rs. {{ $item['total_price'] }}</p>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        
            <hr class="border-gray-300 mb-8">
    
            <!-- Shipping Details -->
            <div class="mb-8">
                <h3 class="text-2xl font-bold mb-6 flex items-center space-x-2 text-gray-700">
                    <x-filament::icon
               
                icon="heroicon-o-truck"
                
                class="h-8 w-8 text-accent dark:text-gray-400"
            />
                    <span>Shipping Details</span>
                </h3>
                <div class="grid grid-cols-1 gap-2 text-gray-600">
                    <p><strong>Name:</strong> {{ session('formState')['first_name'] }} {{ session('formState')['last_name'] }}</p>
                    <p><strong>Phone Number:</strong> {{ session('formState')['phone_number'] }}</p>
                    <p><strong>Address Line 1:</strong> {{ session('formState')['address_line_1'] }}</p>
                    <p><strong>Address Line 2:</strong> {{ session('formState')['address_line_2'] }}</p>
                    <p><strong>City:</strong> {{ session('formState')['city'] }}</p>
                    <p><strong>State:</strong> {{ session('formState')['state'] }}</p>
                    <p><strong>Country:</strong> {{ session('formState')['country'] }}</p>
                    <p><strong>Postal Code:</strong> {{ session('formState')['postal_code'] }}</p>
                </div>
            </div>
    
            <hr class="border-gray-300 mb-8">
            
            <!-- Payment Button -->
            <div class="flex justify-center">
                
                    <form action="{{ route('razorpay.payment.store') }}" method="POST" class="flex justify-center items-center cursor-pointer btn btn-accent btn-wide text-green-100 shadow-lg text-2xl">
                        @csrf
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="{{ env('RAZORPAY_API_KEY') }}"
                            data-amount="{{ session('formState')['total_amount'] * 100 }}"
                            data-buttontext="Pay {{ session('formState')['total_amount'] }} INR"
                            data-name="{{ config('app.name') }}"
                            data-description="A demo razorpay payment"
                            data-image="https://pic.onlinewebfonts.com/svg/img_517853.png"
                            data-prefill.name="{{ Auth::user()->name }}"
                            data-prefill.email="{{ Auth::user()->email }}"
                            data-theme.color="#ff7529">
                        </script>
                    </form>
                
                </div>
            </div>
        </div>
</x-app-layout>
