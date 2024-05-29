<?php

namespace App\Livewire;

use App\Models\Category;
use App\Models\Product;
use Livewire\Component;

class Categories extends Component
{
    public $slug;
    public $category;
    public $products;

    public function mount($slug)
    {
        $this->slug = $slug;
        $this->loadCategoryData();
    }

    public function loadCategoryData()
    {
        $this->category = Category::where('slug', $this->slug)->firstOrFail();
        $this->products = $this->category->products;
    }

    public function render()
    {
        return view('livewire.categories', [
            'category' => $this->category,
            'products' => $this->products,
        ]);
    }
}
