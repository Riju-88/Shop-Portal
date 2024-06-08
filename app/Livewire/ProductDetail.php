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
    protected $listeners = ['productAddedToWishlist' => 'render', 'RemovedFromWishlist' => 'render'];

    public function mount($productId)
    {
        $this->product = Product::findOrFail($productId);
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
