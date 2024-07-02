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
    
   
    <div  @click="categories.showModal()"><a class="p-4  @desktop text-accent @enddesktop @mobile text-black @endmobile @tablet text-black @endtablet hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in cursor-pointer relative">Categories</a></div>
    
<dialog id="categories" class="fixed z-10  rounded-xl @mobile  h-3/5 @endmobile @tablet  h-3/5 @endtablet @desktop h-4/5 @enddesktop">
  <div class="overflow-y-scroll @desktop max-w-6xl w-full h-full  @enddesktop  flex justify-around items-center bg-white/90  p-4  ">

    <div class="@desktop grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3 @enddesktop @mobile overflow-y-scroll  @endmobile ">
  @foreach ($categories as $category)
    <div class="font-bold flex items-center  space-x-2" wire:key="category-{{ $category->id }}">
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
  <div  class="">
    {{-- have to use @click.prevent to stop the form from submitting. Jetstream's logout code somehow causing the logout on this button click --}}
    {{-- these classes in the button act as the outside area. so clicking outside will close the modal --}}
    <div @click="categories.close()" @click.prevent="$root.submit();" class="h-screen w-screen fixed inset-0 bg-black/5 -z-10"></div>
  </div>
</dialog>
  </div>
