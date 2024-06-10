{{-- <details class="dropdown">
    <summary class="p-4 text-amber-600 hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in cursor-pointer list-none">Categories</summary>
    <ul class="my-2 p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
      @foreach ($categories as $category)
        <li class="font-bold flex"><a href="{{ route('categories', $category->slug) }}" class="hover:text-white hover:bg-amber-400">{{ $category->name }}</a></li>
      @endforeach
    </ul>
  </details> --}}

  <!-- Open the modal using ID.showModal() method -->
  <div>
    <button  onclick="{{ $device . '_categories' }}.showModal()"><a class="p-4 @if($device == 'mobile') text-black @else text-accent @endif hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in cursor-pointer">Categories</a></button>
<dialog id="{{ $device . '_categories' }}" class="modal">
  <div class="modal-box max-w-7xl w-full h-3/4 flex justify-around items-center bg-white/90">

    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3">
  @foreach ($categories as $category)
    <div class="font-bold flex items-center space-x-2" wire:key="category-{{ $category->id }}">
      @if($category->image)
      <img src="{{ asset('storage/'.$category->image) }}" alt="category image" class="w-12 h-12 object-cover rounded" />
      @else
      <div class="w-12 h-12 object-cover rounded bg-gray-300"></div>
      @endif
      <a href="{{ route('categories', $category->slug) }}" class="hover:text-white hover:bg-amber-400 p-4 rounded-xl" wire:navigate>{{ $category->name }}</a>
    </div>
  @endforeach
    </div>
  

  </div>

  <form method="dialog" class="modal-backdrop ">
    <button></button>
  </form>
</dialog>
  </div>
