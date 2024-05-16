<?php

namespace App\Livewire;

use Livewire\Component;

class Counter extends Component
{
    public $val = 0;

    public function increase(){
       return $this->val++;
    }
    public function decrease(){
       return $this->val--;
    }
    public function resetVal(){
       return $this->val = 0;
    }
    public function randomize(){
       return $this->val = rand(1,999999);
    }
    public function render()
    {
        return view('livewire.counter');
    }
}
