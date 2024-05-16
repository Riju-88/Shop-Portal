<?php

namespace App\Livewire;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Support\Collection;
use Livewire\Component;

class ProductList extends Component
{
    public int $on_page = 5;
    public $selectedCategories = [];

    public function products(): Collection
    {
        $query = Product::query();

        // Filter by selected categories
        if (!empty($this->selectedCategories)) {
            $query->whereHas('categories', function ($query) {
                $query->whereIn('name', $this->selectedCategories);
            });
        }

        return $query->with('reviews')->latest()->take($this->on_page)->get();
    }

    public function applyFilters(): void
    {
        // Fetch products based on selected filters
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
        $products = $this->products();
        $categories = $this->categories();
        return view('livewire.product-list', compact('products', 'categories'));
    }
}
