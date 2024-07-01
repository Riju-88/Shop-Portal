<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesDropdown extends Component
{
    public $categories;
  

    // mount function will be called when the component is loaded.
    

    // render function will be called when the component is rendered.
    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.categories-dropdown');
    }
}
