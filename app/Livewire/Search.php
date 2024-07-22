<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Search extends Component
{
    // Properties
    public $keyword = '';
    public $results = [];

    public function updatedKeyword()
    {
        // Fetch results based on the keyword whenever it's updated
        $this->search();
    }

    // search method
    public function search()
    {
        // If the keyword is empty, set the results to an empty array
        if ($this->keyword === '') {
            $this->results = [];
        } else {
            // Fetch products from the database where the product name contains the keyword anywhere in the name
            $this->results = Product::where('name', 'like', '%' . $this->keyword . '%')->get();
        }
    }

    public function render()
    {
        return view('livewire.search');
    }
}
