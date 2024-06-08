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
    protected $listeners = ['productAddedToWishlist' => 'render', 'RemovedFromWishlist' => 'render'];
    
    public function mount()
    {
        $this->fetchPriceRangeOptions();
    }

    public function fetchPriceRangeOptions()
    {
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        $rangeIncrement = 5000;
        $currentRange = 0;
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

    public function products(): Collection
    {
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

        return $query->with('reviews')->latest()->take($this->on_page)->get();
    }

    public function applyFilters(): void
    {
        // Fetch products based on selected filters
        $this->products();
    }

    public function clearFilters(): void
    {
        $this->selectedCategories = [];
        $this->selectedPriceRange = null;
        $this->products();
    }

    public function categories(): Collection
    {
        return Category::all();
    }

    public function loadMore(): void
    {
        $this->on_page += 5;
    }

    public function render()
    {
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }

        $products = $this->products();
        $categories = $this->categories();
        return view('livewire.product-list', compact('products', 'categories'));
    }
}
