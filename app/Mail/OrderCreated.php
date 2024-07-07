<?php

namespace App\Mail;

use App\Models\Order;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\ShippingMethod;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailables\Address;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Auth;

class OrderCreated extends Mailable
{
    use Queueable, SerializesModels;

    public $orderItems;
    public $shipping;
    public $shippingMethod;

    /**
     * Create a new message instance.
     */
    public function __construct(
        public Order $order,
    ) {
        //
        // Decode the items JSON
        $items = json_decode($order->items, true);

        // Retrieve product details for each item
        $this->orderItems = array_map(function ($item) {
            $product = Product::find($item['product_id']);
            return [
                'product' => $product,
                'quantity' => $item['quantity'],
            ];
        }, $items);

        // Retrieve shipping details
        $this->shipping = Shipping::find($order->shipping_id);

        // Retrieve shipping method details
        if ($this->shipping) {
            $this->shippingMethod = ShippingMethod::find($this->shipping->shipping_method_id);
        }
    }

    /**
     * Get the message envelope.
     */
    public function envelope(): Envelope
    {
        return new Envelope(
            from: new Address(env('MAIL_FROM_ADDRESS'), env('MAIL_FROM_NAME') . ' Admin'),
            subject: 'Order Created',
        );
    }

    /**
     * Get the message content definition.
     */
    public function content(): Content
    {
        return new Content(
            view: 'emails.order-created',
        );
    }

    /**
     * Get the attachments for the message.
     *
     * @return array<int, \Illuminate\Mail\Mailables\Attachment>
     */
    public function attachments(): array
    {
        return [];
    }
}
