<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductList extends Component
{
    public int $on_page = 5;
    public $selectedCategories = [];
    public $priceRangeOptions = [];
    public $selectedPriceRange = null;
    public $wishlist;

    // Listeners
    protected $listeners = ['productAddedToWishlist' => 'render', 'RemovedFromWishlist' => 'render'];

    public function mount()
    {
        // Call method to Fetch price range options
        $this->fetchPriceRangeOptions();
    }
    // Fetch price range options
    public function fetchPriceRangeOptions()
    {
        // get min and max price
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        // calculate price range increment
        $rangeIncrement = 5000;
        $currentRange = 0;
        
        // add price range options
        while ($currentRange < $maxPrice) {
            $nextRange = $currentRange + $rangeIncrement;
            if ($nextRange > $maxPrice) {
                $nextRange = $maxPrice;
            }
            $label = $currentRange . ' - ' . $nextRange;
            $this->priceRangeOptions[] = ['label' => $label, 'range' => [$currentRange, $nextRange]];
            $currentRange = $nextRange;
        }
    }

    // Fetch products
    public function products(): Collection
    {
        // Fetch products
        $query = Product::query();

        // Filter by selected categories
        if (!empty($this->selectedCategories)) {
            $query->whereHas('categories', function ($query) {
                $query->whereIn('name', $this->selectedCategories);
            });
        }

        // Filter by price range
        if ($this->selectedPriceRange !== null) {
            $priceRange = json_decode($this->selectedPriceRange, true);
            if (is_array($priceRange) && count($priceRange) == 2) {
                $query->whereBetween('price', $priceRange);
            }
        }

        // Fetch products based on selected filters
        return $query->with('reviews')->latest()->take($this->on_page)->get();
    }

    // Apply filters
    public function applyFilters(): void
    {
        // Fetch products based on selected filters
        $this->products();
    }

    // Clear filters
    public function clearFilters(): void
    {
        $this->selectedCategories = [];
        $this->selectedPriceRange = null;
        $this->products();
    }

    // Fetch categories
    public function categories(): Collection
    {
        return Category::all();
    }

    // Load more products
    public function loadMore(): void
    {
        $this->on_page += 5;
    }

    // Render
    public function render()
    {
        // Check if user is logged in and fetch wishlist
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }

        // Fetch products
        $products = $this->products();
        // Fetch categories
        $categories = $this->categories();
        return view('livewire.product-list', compact('products', 'categories'));
    }
}
