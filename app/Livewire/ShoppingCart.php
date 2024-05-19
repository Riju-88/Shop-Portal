<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

class ShoppingCart extends Component
{
    public $carts;
    public $cart_open = false;

    public function mount()
    {
        if (auth()->check()) {
            $user = auth()->user();
            $this->carts = $user->cart()->with('product')->get()->toArray();
        } else {
            $this->carts = [];  // Set $carts to an empty array if the user is not authenticated
        }
    }

    #[On('add-To-Cart')]
    public function addToCart($id)
    {
        if (!auth()->check()) {
            \Log::info('Auth failed');
            return;  // Return if the user is not authenticated
        }

        $user = auth()->user();
        $product = Product::find($id);  // Assuming Product is the model for your products

        if (!$product) {
            \Log::error('Product not found with ID: ' . $id);
            return;
        }

        $cart = $user->cart ?? new Cart();  // Retrieve the user's cart or create a new one if it doesn't exist

        // Check if the product already exists in the cart
        $existingCartItem = $cart->where('product_id', $id)->first();

        if ($existingCartItem) {
            $existingCartItem->increment('quantity');  // Increment quantity if the product already exists in the cart
            $existingCartItem->update(['total_price' => $existingCartItem->quantity * $product->price]);  // Update total price
        } else {
            // Create a new cart item for the product
            $cartItem = new Cart();
            $cartItem->user_id = $user->id;
            $cartItem->product_id = $product->id;
            $cartItem->quantity = 1;
            // total price calculation
            $cartItem->total_price = $cartItem->quantity * $product->price;
            $cartItem->save();  // Save the cart item instance to the database

            // Notify the user that the product has been added to the cart
            // $this->dispatchBrowserEvent('notify', 'Product added to cart successfully!');

            Notification::make()
                ->title('Product added to cart successfully!')
                ->success()
                ->send();
        }

        \Log::info('Add to Cart button clicked. Product ID: ' . $id);
        // Refresh the cart data after adding the product
        $this->mount();
    }

    public function updateQuantity($index)
    {
        // Logic to update quantity of an item in the cart
        $cartItem = $this->carts[$index];
        $user = auth()->user();  // Assuming user is authenticated
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $cartItem['product']['id'])
            ->first();

        if ($cart) {
            $cart->quantity = $cartItem['quantity'];
            $cart->total_price = $cartItem['quantity'] * $cartItem['product']['price'];
            $cart->save();
            $this->mount();
        }
    }
    // public function updateQuantity($itemId, $quantity)
    // {
    //     // Logic to update quantity of an item in the cart
    // }

    public function incrementQuantity($index)
    {
        $cartItem = $this->carts[$index];
        $product = Product::find($cartItem['product']['id']);

        if ($product && $cartItem['quantity'] < $product->quantity) {
            $cartItem['quantity']++;
            $this->carts[$index] = $cartItem;
            $this->updateQuantity($index);
        }
    }

    public function decrementQuantity($index)
    {
        if ($this->carts[$index]['quantity'] > 1) {
            $this->carts[$index]['quantity']--;
            $this->updateQuantity($index);
        }
    }

    public function removeItem($index)
    {
        // Logic to remove an item from the cart
        $cartItem = $this->carts[$index];
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $cartItem['product']['id'])
            ->first();

        if ($cart) {
            $cart->delete();
        }

        $this->mount();
    }

    public function checkout()
    {
        // Ensure the user is authenticated
        if (!auth()->check()) {
            // Redirect to login or display an error message
            return;
        }

        // Validate the cart contents
        if (empty($this->cart['items'])) {
            // Handle empty cart scenario
            return;
        }

        // Calculate the total amount to be charged
        // Calculate the total amount based on cart items
        $totalAmount = 0;

        // Create a Razorpay order
        $order = $this->createRazorpayOrder($totalAmount);

        // Redirect the user to the Razorpay checkout page
        return redirect()->to($order->checkoutUrl());
    }

    private function createRazorpayOrder($amount)
    {
        $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));

        // Create an order
        $order = $api->order->create([
            'amount' => $amount * 100,  // Amount in paisa
            'currency' => 'INR',  // Change currency as needed
            // Add more options as required
        ]);

        return $order;
    }

    public function render()
    {
        if (!auth()->check()) {
            return '';  // Return an empty string if the user is not authenticated
        }

        return view('livewire.shopping-cart');
    }
}
