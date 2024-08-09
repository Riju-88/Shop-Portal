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
        $this->categories = $this->productsByCategory();
    }

    // Fetch price range options
    public function fetchPriceRangeOptions()
    {
        // Get min and max price
        $minPrice = Product::min('price');
        $maxPrice = Product::max('price');

        // Calculate price range increment
        $rangeIncrement = 5000;
        $currentRange = $minPrice;

        // Add price range options
        while ($currentRange <= $maxPrice) {
            $nextRange = $currentRange + $rangeIncrement;
            if ($nextRange > $maxPrice) {
                $nextRange = $maxPrice;
            }
            $label = $currentRange . ' - ' . $nextRange;
            $this->priceRangeOptions[] = ['label' => $label, 'range' => [$currentRange, $nextRange]];
            $currentRange = $nextRange + 0.01;  // Move to the next range, accounting for decimal precision
        }
    }

    public function productsByCategory(): Collection
    {
        // Fetch price range options if not already fetched
        if (empty($this->priceRangeOptions)) {
            $this->fetchPriceRangeOptions();
        }

        // Fetch products globally with the price range filter applied
        $productsQuery = Product::query();

        if ($this->selectedPriceRange !== null) {
            $priceRange = json_decode($this->selectedPriceRange, true);
            if (is_array($priceRange) && count($priceRange) == 2) {
                $productsQuery->whereBetween('price', $priceRange);
            }
        }

        // Get the filtered products
        $filteredProducts = $productsQuery->latest()->get();

        // Fetch categories and eager load their products
        $categoriesQuery = Category::query();

        if (!empty($this->selectedCategories)) {
            $categoriesQuery->whereIn('name', $this->selectedCategories);
        }

        $categories = $categoriesQuery->with('children')->get();

        // Create a map of products by category
        $categoryProductsMap = [];

        foreach ($categories as $category) {
            $categoryProductsMap[$category->id] = $filteredProducts->filter(function ($product) use ($category) {
                return $product->categories->contains($category);
            });

            // Map products to child categories as well
            foreach ($category->children as $childCategory) {
                $categoryProductsMap[$childCategory->id] = $filteredProducts->filter(function ($product) use ($childCategory) {
                    return $product->categories->contains($childCategory);
                });
            }
        }

        // Attach the filtered products to their respective categories
        foreach ($categories as $category) {
            $category->products = $categoryProductsMap[$category->id];

            foreach ($category->children as $childCategory) {
                $childCategory->products = $categoryProductsMap[$childCategory->id];
            }
        }

        return $categories;
    }

    // Apply filters
    public function applyFilters(): void
    {
        // Fetch products based on selected filters
        $this->categories = $this->productsByCategory();
    }

    // Clear filters
    public function clearFilters(): void
    {
        $this->selectedCategories = [];
        $this->selectedPriceRange = null;
        $this->categories = $this->productsByCategory();
    }

    // Fetch categories
    public function categories(): Collection
    {
        return Category::all();
    }

    // Render
    public function render()
    {
        // Check if user is logged in and fetch wishlist
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }

        // Fetch products by category
        $this->categories = $this->productsByCategory();

        return view('livewire.product-list', [
            'categories' => $this->categories,
        ]);
    }
}
