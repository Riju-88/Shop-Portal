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
    // listeners is an array of events and their corresponding listeners.
    protected $listeners = ['render-category' => 'render'];

    // This function is called when the component is mounted.
    // It assigns the value of the slug parameter to the $slug property.
    // It then calls the loadCategoryData method to load the category and products data into the $category and $products properties respectively.

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadCategoryData();
    }

    // This function is called when the wishlist-add-category event is dispatched.
    #[On('wishlist-add-category')]
    public function addToWishlist($product_id)
    {
        $this->dispatch('add-to-wishlist', product_id: $product_id);
        $this->dispatch('render-category');
    }

    // This function loads the category and products data into the $category and $products properties respectively.
    public function loadCategoryData()
    {
        $this->category = Category::where('slug', $this->slug)->firstOrFail();
        $this->products = $this->category->products;
    }

    // This function renders the component.
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
