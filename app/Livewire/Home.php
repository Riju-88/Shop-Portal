<?php

namespace App\Livewire;

use App\Models\Promo;
use Livewire\Component;

class Home extends Component
{
    public function render()
    {
        // Retrieve the most recently updated promo that is active
        $promo = Promo::where('active', true)->orderBy('updated_at', 'desc')->first();
        return view('livewire.home', compact('promo'));
    }
}
