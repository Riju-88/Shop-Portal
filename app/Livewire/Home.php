<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
    public $wishlist;
    public $products;
    public $categories;
    public $promo;
    protected $listeners = ['productAddedToWishlist' => 'render', 'RemovedFromWishlist' => 'render'];

    public function render()
    {
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }

        $this->products = Product::where('is_featured', 1)->get();
        $this->categories = Category::all();

        // Retrieve the most recently updated promo that is active
        $this->promo = Promo::where('active', true)->orderBy('updated_at', 'desc')->first();
        return view('livewire.home');
    }
}
