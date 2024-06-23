<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use Filament\Notifications\Notification;
use Livewire\Attributes\On;
use Livewire\Component;

// use Safemood\Discountify\Facades\Discountify;

class ShoppingCart extends Component
{
    public $carts;
    public $cart_open = false;

    // totals for subtotal, total discount, and total price
    public $totals = [
        'subtotal' => 0,
        'totalDiscount' => 0,
        'totalPrice' => 0,
    ];

    public function mount()
    {
        // Get the user's cart items if the user is authenticated
        if (auth()->check()) {
            $user = auth()->user();
            $this->carts = $user->cart()->with('product.categories')->get()->toArray();

            // Recalculate discounts
            $this->calculateDiscount();
        } else {
            $this->carts = [];  // Set $carts to an empty array if the user is not authenticated
        }
    }

    // Add product to cart
    #[On('add-To-Cart')]
    public function addToCart($id)
    {
        // if user is not authenticated return
        if (!auth()->check()) {
            // \Log::info('Auth failed');
            return;  // Return if the user is not authenticated
        }

        // get user and product
        $user = auth()->user();
        $product = Product::find($id);  // Find the product with the given ID

        // if product not found
        if (!$product) {
            // \Log::error('Product not found with ID: ' . $id);
            return;
        }
        // if product exists in wishlist remove it
        if ($user->wishlist()->where('product_id', $id)->exists()) {
            $user->wishlist()->where('product_id', $id)->delete();
            Notification::make()
                ->title('Product removed from wishlist!')
                ->success()
                //     ->icon('heroicon-m-check-circle')
                // ->iconColor('success')
                ->send();
        }

      
        $cart = $user->cart ?? new Cart();  // Retrieve the user's cart or create a new one if it doesn't exist

        // Check if the product already exists in the cart
        $existingCartItem = $cart->where('product_id', $id)->first();

        // If the product exists in the cart, increment its quantity
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

            // Send notification
            Notification::make()
                ->title('Product added to cart successfully!')
                ->success()
                //     ->icon('heroicon-m-check-circle')
                // ->iconColor('success')
                ->send();
        }

        // \Log::info('Add to Cart button clicked. Product ID: ' . $id);
        // Refresh the cart data after adding the product
        $this->mount();
    }

    // Update cart item quantity
    public function updateQuantity($index)
    {
        // Get the cart item at the specified index
        $cartItem = $this->carts[$index];
        $user = auth()->user();  // Assuming user is authenticated
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $cartItem['product']['id'])
            ->first();

        // Update the cart item quantity
        if ($cart) {
            $cart->quantity = $cartItem['quantity'];
            $cart->total_price = $cartItem['quantity'] * $cartItem['product']['price'];
            $cart->save();
            $this->mount();
        }
    }

    // Increment cart item quantity
    public function incrementQuantity($index)
    {
        $cartItem = $this->carts[$index];
        $product = Product::find($cartItem['product']['id']);

        // Check if the product quantity is less than the available quantity
        if ($product && $cartItem['quantity'] < $product->quantity) {
            $cartItem['quantity']++;
            $this->carts[$index] = $cartItem;
            $this->updateQuantity($index);
            $this->calculateDiscount();  // Recalculate discounts
        }
    }

    // Decrement cart item quantity
    public function decrementQuantity($index)
    {
        // Decrement the quantity if the quantity is greater than 1
        if ($this->carts[$index]['quantity'] > 1) {
            $this->carts[$index]['quantity']--;
            $this->updateQuantity($index);
            $this->calculateDiscount();  // Recalculate discounts
        }
    }

    // Remove item from cart
    public function removeItem($index)
    {
        // Remove the item from the cart
        $cartItem = $this->carts[$index];
        $user = auth()->user();
        $cart = Cart::where('user_id', $user->id)
            ->where('product_id', $cartItem['product']['id'])
            ->first();

        // Delete the cart item if it exists
        if ($cart) {
            $cart->delete();
        }

        $this->mount();
        $this->calculateDiscount();  // Recalculate discounts
    }

    //  calculate discount
    public function calculateDiscount()
    {
        $subtotal = 0;
        $totalDiscount = 0;

        // Loop through the cart items
        foreach ($this->carts as $cartItem) {
            $price = $cartItem['product']['price'];
            $quantity = $cartItem['quantity'];
            $itemTotalPrice = $price * $quantity;
            $subtotal += $itemTotalPrice;

            // Calculate the discount for this item
            $itemDiscount = 0;
            foreach ($cartItem['product']['categories'] as $category) {
                $itemDiscount += ($itemTotalPrice * ($category['discount'] / 100));
            }

            // Add the item's discount to the total discount
            $totalDiscount += $itemDiscount;
        }

        $totalPrice = $subtotal - $totalDiscount;

        // Update the totals
        $this->totals = [
            'subtotal' => $subtotal,
            'totalDiscount' => $totalDiscount,
            'totalPrice' => $totalPrice,
        ];
    }

    public function render()
    {
        if (!auth()->check()) {
            return '';  // Return an empty string if the user is not authenticated
        }

        return view('livewire.shopping-cart', [
            'carts' => $this->carts,
            'totals' => $this->totals,
        ]);
    }
}
