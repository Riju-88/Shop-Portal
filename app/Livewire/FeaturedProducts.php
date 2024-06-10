<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class FeaturedProducts extends Component
{
    public $wishlist;
    public $products;
    public $categories;
    public $promo;
    public $device;
    protected $listeners = ['productAddedToWishlist' => 'render', 'RemovedFromWishlist' => 'render'];

    public function mount($device)
    {
        $this->device = $device;
    }

    public function render()
    {
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }

        $this->products = Product::where('is_featured', 1)->get();
        $this->categories = Category::all();

        return view('livewire.featured-products');
    }
}
