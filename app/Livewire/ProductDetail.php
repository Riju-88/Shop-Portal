<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class ProductDetail extends Component
{
    public $product;
    public $rating;
    public $wishlist;

    // listeners
    protected $listeners = ['productAddedToWishlist' => 'render', 'RemovedFromWishlist' => 'render'];

    // mount function
    public function mount($productId)
    {
        // get product with attributes
        $this->product = Product::with('attributes')->find($productId);
        // get product rating
        $this->rating = $this->product->reviews()->avg('rating');
    }

    public function render()
    {
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }

        return view('livewire.product-detail');
    }
}
