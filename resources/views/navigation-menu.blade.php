<nav class="bg-white shadow-md fixed w-full z-10 transition-transform duration-300 ease-in-out top-0" x-data="{ sidebarOpen: false }">
    <!-- Mobile Navbar -->
    <div class="flex justify-between md:hidden">
        <!-- Hamburger Menu -->
        <button @click="sidebarOpen = !sidebarOpen"
            class="p-4 focus:outline-none focus:bg-gray-100 focus:text-gray-600">
            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 6h16M4 12h16m-7 6h7"></path>
            </svg>
        </button>
        <!-- Logo -->
        <div class="flex items-center">
            <a href="#" class="p-4 text-lg font-semibold text-gray-800">Logo</a>
        </div>
    </div>

    <!-- Sidebar -->
    <div x-show="sidebarOpen" 
    class="fixed inset-0 z-50 bg-black bg-opacity-25 md:hidden"
    x-transition:enter="transition ease-in-out duration-500"
    x-transition:enter-start="opacity-0"
    x-transition:enter-end="opacity-100">
</div>

<div x-show="sidebarOpen" @click.away="sidebarOpen = false"
    class="fixed inset-y-0 left-0 z-50 w-64 bg-white shadow-md md:hidden"
    x-transition:enter="transition ease-in-out duration-500 transform"
    x-transition:enter-start="-translate-x-full"
    x-transition:enter-end="translate-x-0"
    x-transition:leave="transition ease-in-out duration-500 transform"
    x-transition:leave-start="translate-x-0"
    x-transition:leave-end="-translate-x-full">
        <div class="flex flex-col w-64 bg-white h-full shadow-md">
            <!-- Close Button -->
            <div class="flex justify-end p-4">
                <button @click="sidebarOpen = false"
                    class="focus:outline-none focus:bg-gray-100 focus:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>
            <!-- Sidebar Links -->
            <ul class="py-4" @click.away.stop>
                <li><a href="{{ route('home') }}" class="block p-4 hover:bg-gray-100">Home</a></li>
                <li><a href="#" class="block p-4 hover:bg-gray-100">About</a></li>
                <li><a href="{{ route('productList') }}" class="block p-4 hover:bg-gray-100">Products</a></li>
                <li><a href="#" class="block p-4 hover:bg-gray-100">Contact</a></li>
            </ul>
        </div>
    </div>

    <!-- Desktop Navbar -->
    <div class="hidden md:flex justify-center items-center">
        <!-- Logo -->
        <a href="#" class="p-4 text-lg font-semibold text-gray-800">Logo</a>
        <!-- Navigation Links -->
        <ul class="flex items-center">
            <li><a href="{{ route('home') }}" class="p-4 text-amber-600 hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in">Home</a></li>
            <li><a href="{{ route('productList') }}" class="p-4 text-amber-600 hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in">Products</a></li>
            <li><a href="#" class="p-4 text-amber-600 hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in">About</a></li>
            <li><a href="#" class="p-4 text-amber-600 hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in">Contact</a></li>
        </ul>
        {{-- livewire search component --}}
        <livewire:search />
        {{-- end livewire search component --}}

        <div class="ml-4">
         <!-- Cart Modal Structure -->
    <livewire:ShoppingCart />
    {{-- end Cart Modal Structure --}}
</div>
    </div>
</nav>