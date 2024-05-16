<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Product;

class ProductDetail extends Component
{
    public $product;
    public $rating;

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
        $this->rating = $this->product->reviews()->avg('rating');
    }

   
    public function render()
    {
        return view('livewire.product-detail');
    }
}
