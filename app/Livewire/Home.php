<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Promo;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Home extends Component
{
    public $promo;
    public $productShowcase;
    protected $listeners = ['render-showcase' => 'render'];

    #[On('wishlist-add-showcase')]
    public function addToWishlist($product_id)
    {
        $this->dispatch('add-to-wishlist', product_id: $product_id);
        $this->dispatch('render-showcase');
    }

    public function render()
    {
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }
        // Retrieve the most recently updated promo that is active
        $this->promo = Promo::where('active', true)->orderBy('updated_at', 'desc')->first();

        // get latest 8 products in random order
        $this->productShowcase = Product::latest()->take(8)->get();

        return view('livewire.home');
    }
}
