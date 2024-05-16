<div class="container mx-auto">
    {{-- A good traveler has no fixed plans and is not intent upon arriving. --}}
    <div class="flex justify-center">
          <h1 class="text-lg font-bold btn">Value: {{ $val }}</h1>
    </div>

    <div class="flex justify-center gap-2">
    <div><button wire:click="increase()" class="btn btn-success">Increase</button></div>
    <div><button wire:click="decrease()" class="btn btn-error">Decrease</button></div>
    <div><button wire:click="resetVal()" class="btn btn-info">Reset</button></div>
    <div><button wire:click="randomize()" class="btn btn-warning">Randomize</button></div>
</div>
</div>
