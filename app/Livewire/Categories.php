<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class Categories extends Component
{
    public $slug;
    public $category;
    public $products;
    public $productCategory;
    protected $listeners = ['render-category' => 'render'];

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadCategoryData();
    }

    #[On('wishlist-add-category')]
    public function addToWishlist($product_id)
    {
        $this->dispatch('add-to-wishlist', product_id: $product_id);
        $this->dispatch('render-category');
    }

    public function loadCategoryData()
    {
        $this->category = Category::where('slug', $this->slug)->firstOrFail();
        $this->products = $this->category->products;
    }

    public function render()
    {
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }
        return view('livewire.categories', [
            'category' => $this->category,
            'products' => $this->products,
        ]);
    }
}
