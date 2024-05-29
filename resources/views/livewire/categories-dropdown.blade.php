<details class="dropdown">
    <summary class="p-4 text-amber-600 hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in cursor-pointer list-none">Categories</summary>
    <ul class="my-2 p-2 shadow menu dropdown-content z-[1] bg-base-100 rounded-box w-52">
      @foreach ($categories as $category)
        <li class="font-bold flex"><a href="{{ route('categories', $category->slug) }}" class="hover:text-white hover:bg-amber-400">{{ $category->name }}</a></li>
      @endforeach
    </ul>
  </details>
