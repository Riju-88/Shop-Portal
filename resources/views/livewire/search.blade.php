<div class="shadow-sm relative rounded-md">
   
 

    <x-filament::input.wrapper prefix-icon="heroicon-m-magnifying-glass">
    <x-filament::input
        type="search"
        wire:model.defer="keyword"
        wire:input="search"
        placeholder="Search"
        
       
    />
</x-filament::input.wrapper>
    @if(count($results) > 0)
    <ul class="absolute w-full bg-white shadow-md rounded-md mt-2">
        @foreach($results as $result)
        <li class="py-2 px-4 hover:bg-gray-100"><a href="{{ route('product.detail', $result->id) }}">{{ $result->name }}</a></li>
        @endforeach
    </ul>
    @elseif($keyword != '')
    <ul class="absolute w-full bg-white shadow-md rounded-md mt-2">
    <li class="py-2 px-4 hover:bg-gray-100">No results found</li>
</ul>
    @endif
</div>

 {{-- <input type="search" wire:model.defer="keyword" wire:input="search" class="border-0 m-1 border-transparent bg-white h-10 px-5 pr-16 rounded-lg text-sm focus:outline-none !important"> --}}

