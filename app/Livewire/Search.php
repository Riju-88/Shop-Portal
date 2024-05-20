<?php

namespace App\Livewire;

use App\Models\Product;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Livewire\Component;

class Search extends Component
{
    public $keyword = '';
    public $results = [];

    public function updatedKeyword()
    {
        // Fetch results based on the keyword whenever it's updated
        $this->search();
    }

    public function search()
    {
        if ($this->keyword === '') {
            $this->results = [];
        } else {
            // Fetch results based on the keyword
            $this->results = Product::where('name', 'like', $this->keyword . '%')
                ->whereRaw('CHAR_LENGTH(name) >= ?', [strlen($this->keyword)])
                ->get();
        }
    }

    public function render()
    {
        return view('livewire.search');
    }
}
