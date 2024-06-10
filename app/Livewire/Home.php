<?php

namespace App\Livewire;

use App\Models\Promo;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class Home extends Component
{
   
    public $promo;


    public function render()
    {
     
        // Retrieve the most recently updated promo that is active
        $this->promo = Promo::where('active', true)->orderBy('updated_at', 'desc')->first();
        return view('livewire.home');
    }
}
