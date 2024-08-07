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

        // Start with an empty collection for products
        $filteredProducts = collect();

        if (!empty($this->selectedCategories)) {
            // Get the selected categories' IDs
            $selectedCategoryIds = Category::whereIn('name', $this->selectedCategories)->pluck('id')->toArray();

            // Fetch products directly associated with the selected categories
            $filteredProducts = Product::whereHas('categories', function ($query) use ($selectedCategoryIds) {
                $query->whereIn('category_id', $selectedCategoryIds);
            })
                ->when($this->selectedPriceRange !== null, function ($query) {
                    $priceRange = json_decode($this->selectedPriceRange, true);
                    if (is_array($priceRange) && count($priceRange) == 2) {
                        $query->whereBetween('price', $priceRange);
                    }
                })
                ->get();
        } else {
            // If no categories are selected, fetch all products
            $filteredProducts = Product::when($this->selectedPriceRange !== null, function ($query) {
                $priceRange = json_decode($this->selectedPriceRange, true);
                if (is_array($priceRange) && count($priceRange) == 2) {
                    $query->whereBetween('price', $priceRange);
                }
            })
                ->get();
        }

        // Fetch the categories and their children
        $categories = Category::with('children')->get();

        // Create a map of products by category
        $categoryProductsMap = [];

        foreach ($categories as $category) {
            // Filter products for the current category
            $categoryProductsMap[$category->id] = $filteredProducts->filter(function ($product) use ($category) {
                return $product->categories->contains($category);
            });

            // Filter products for each child category
            foreach ($category->children as $childCategory) {
                $categoryProductsMap[$childCategory->id] = $filteredProducts->filter(function ($product) use ($childCategory) {
                    return $product->categories->contains($childCategory);
                });
            }
        }

        // Attach the filtered products to their respective categories
        foreach ($categories as $category) {
            $category->products = $categoryProductsMap[$category->id] ?? collect();

            foreach ($category->children as $childCategory) {
                $childCategory->products = $categoryProductsMap[$childCategory->id] ?? collect();
            }
        }

        return $categories;
    }

    // Apply filters
    public function applyFilters()
    {
        $query = Product::query();

        if (!empty($this->selectedCategories)) {
            // Get the selected categories' IDs by their names
            $selectedCategoryIds = Category::whereIn('name', $this->selectedCategories)
                ->pluck('id')
                ->toArray();

            // Fetch only products that belong directly to the selected categories
            $query->whereHas('categories', function ($query) use ($selectedCategoryIds) {
                $query->whereIn('category_id', $selectedCategoryIds);
            });
        }

        // Apply price range filtering if selected
        if ($this->selectedPriceRange !== null) {
            $priceRange = json_decode($this->selectedPriceRange, true);
            if (is_array($priceRange) && count($priceRange) == 2) {
                $query->whereBetween('price', $priceRange);
            }
        }

        $this->products = $query->get();
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
