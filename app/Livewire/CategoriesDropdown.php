<?php

namespace App\Livewire;

use App\Models\Category;
use Livewire\Component;

class CategoriesDropdown extends Component
{
    public $categories;
    public $device;
    

    public function mount($device)
    {
        $this->device = $device;
    }
    public function render()
    {
        $this->categories = Category::all();
        return view('livewire.categories-dropdown');
    }
}
