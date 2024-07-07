{{-- compose the email template for order created --}}
<section>
    <h1>Order Created</h1>
    <p>Hi {{ Auth::user()->name }},</p>
    <p>Your order has been created successfully.</p>
    <p>Order Details:</p>

    <p>Order Number: {{ $order->order_number }}</p>
    <p>Order Status: {{ $order->status }}</p>
    <p>Payment Method: {{ $order->payment_method }}</p>
    <p>Payment Status: {{ $order->payment_status }}</p>
    <p>Total Amount: {{ $order->total_amount }}</p>
    <h2>Ordered Items:</h2>
    <ul>
        @foreach ($orderItems as $item)
            <li>
                {{ $item['product']->name }} - Quantity: {{ $item['quantity'] }}
            </li>
        @endforeach
    </ul>

    <h2>Shipping Information:</h2>
    @if ($shipping)
        <p>Name: {{ $shipping->first_name }} {{ $shipping->last_name }}</p>
        <p>Phone: {{ $shipping->phone_number }}</p>
        <p>Address: {{ $shipping->address_line_1 }} {{ $shipping->address_line_2 }}</p>
        <p>City: {{ $shipping->city }}</p>
        <p>State: {{ $shipping->state }}</p>
        <p>Postal Code: {{ $shipping->postal_code }}</p>
        <p>Country: {{ $shipping->country }}</p>
        <p>Order Date: {{ $shipping->created_at->format('F j, Y, g:i a') }}</p>
        
        <h3>Shipping Method:</h3>
        @if ($shippingMethod)
            <p>Method: {{ $shippingMethod->shipping_method_name }}</p>
            <p>Description: {{ $shippingMethod->shipping_method_description }}</p>
            <p>Expected Delivery Time: {{ $shippingMethod->expected_delivery_time }}</p>
            <p>Cost: {{ $shippingMethod->cost }}</p>
        @endif
    @else
        <p>No shipping information available.</p>
    @endif
    <strong>(For any queries regarding your order or any other assistance, please contact us at {{ env('MAIL_FROM_ADDRESS') }})</strong>

    <p>Thank you for your order!</p>
    <p>Best regards,</p>
    <p>{{ config('app.name') }}</p>
</section>