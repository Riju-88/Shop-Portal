<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Payment Gateway') }}
        </h2>
    </x-slot>

    <div class="container mx-auto p-4">
        <div class="bg-white shadow-md rounded-lg p-6">
            <!-- Order Summary -->
            <div class="my-4  pb-4">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <x-filament::icon
                   
                    icon="heroicon-o-shopping-cart"
                    
                    class="h-8 w-8 text-gray-500 dark:text-gray-400"
                />
                   
                    Order Summary
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
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

            <div class="divider"></div> 

            <!-- Shipping Details -->
            <div class="my-4 pb-4">
                <h3 class="text-lg font-semibold mb-4 flex items-center">
                    <x-filament::icon
                   
                    icon="heroicon-o-truck"
                    
                    class="h-8 w-8 text-gray-500 dark:text-gray-400"
                />
                    Shipping Details
                </h3>
                <div>
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

            <div class="divider"></div> 
            
            <!-- Payment Button -->
            <div class="text-center my-4">
                <div class="btn btn-accent text-green-100 shadow-lg">
                    <form action="{{ route('razorpay.payment.store') }}" method="POST">
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
    </div>
</x-app-layout>
