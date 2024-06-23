<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Session;
use Livewire\Component;

class RazorpayGateway extends Component
{
    public $formState;

    public function render()
    {
        // Check if form state exists in session
        if (session()->has('formState')) {
            $this->formState = session('formState');

            // Add product names and apply category discounts to cart items
            foreach ($this->formState['cart_items'] as &$item) {
                // Fetch product details including categories
                $product = Product::with('categories')->find($item['product_id']);

                // Calculate total price including discounts from categories
                $itemTotalPrice = $item['total_price'];
                $itemDiscount = 0;

                // Apply category discounts
                if ($product) {
                    foreach ($product->categories as $category) {
                        $itemDiscount += ($itemTotalPrice * ($category->discount / 100));
                    }
                }

                // Apply discount to total price
                $item['total_price'] = round($item['total_price'] - $itemDiscount, 2);

                // Set product name
                $item['product_name'] = $product ? $product->name : 'Unknown Product';
            }
            // unset reference to avoid unintended side effects
            unset($item);
            return view('livewire.razorpay-gateway', ['formState' => $this->formState]);
        } else {
            return redirect()->back();
        }
    }
}
