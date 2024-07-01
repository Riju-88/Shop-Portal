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
    @mobile
    <div  @click="categories.showModal()" @click.prevent="$root.submit();"><a class="p-4 text-black hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in cursor-pointer">Categories</a></div>
    @endmobile
    @desktop
    <div  @click="categories.showModal()"><a class="p-4 text-accent hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in cursor-pointer">Categories</a></div>
    @enddesktop
<dialog id="categories" class="modal">
  <div class="modal-box max-w-6xl w-full  flex justify-around items-center bg-white/90 overflow-y-scroll">

    <div class="@desktop grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 @enddesktop @mobile flex items-center flex-wrap justify-center @endmobile ">
  @foreach ($categories as $category)
    <div class="font-bold flex items-center space-x-2 my-8" wire:key="category-{{ $category->id }}">
      @if($category->image)
      <img src="{{ asset('storage/'.$category->image) }}" alt="category image" class="w-12 h-12 object-cover rounded" />
      @else
      <div class="w-12 h-12 object-cover rounded bg-gray-300"></div>
      @endif
      <a href="{{ route('categories', $category->slug) }}" class="hover:text-white hover:bg-accent p-4 rounded-xl" wire:navigate>{{ $category->name }}</a>
    </div>
  @endforeach
    </div>
  

  </div>

  {{-- Close --}}
  {{-- need the reletive class here to make the button absolute --}}
  <div  class="modal-backdrop relative">
    {{-- have to use @click.prevent to stop the form from submitting. Jetstream's logout code somehow causing the logout on this button click --}}
    {{-- these classes in the button act as the outside area. so clicking outside will close the modal --}}
    <div @click="categories.close()" @click.prevent="$root.submit();" class="h-screen w-screen absolute inset-0 -z-10"></div>
  </div>
</dialog>
  </div>
