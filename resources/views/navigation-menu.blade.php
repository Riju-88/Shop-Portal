
<nav x-data="{ isScrolled: false, lastScroll: 0, sidebarOpen: false }" x-init="window.addEventListener('scroll', () => { let currentScroll = window.pageYOffset; isScrolled = currentScroll > lastScroll && currentScroll > 10; lastScroll = currentScroll })">
    <div :class="{ '-translate-y-20': isScrolled, 'translate-y-0': !isScrolled }" class="bg-white shadow-md fixed top-0 w-full z-50 transition duration-500 ease-in-out">
      
{{-- <div class="bg-white shadow-md fixed w-full z-10 transition-transform duration-300 ease-in-out top-0" x-data="{ sidebarOpen: false }"> --}}
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
            @auth
            @mobile
            <div class="relative m-3"> <livewire:ShoppingCart /></div>
            @endmobile
            @endauth
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
            <div class="flex flex-col w-64 bg-white bg-opacity-95 bg-blend-lighten h-screen shadow-md z-40">
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
                    {{-- profile test --}}
                    @if(Auth::check())
                    <li>
                        <div class="mx-2">
                            <div class="flex justify-center items-center">
                                 <div class="avatar">
                                <div class="w-12 rounded-full">
                                  <img src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                </div>
                              </div>
                            </div>
                           
                              {{-- profile dropdown --}}
                              <div x-data="{ checked: false }" class="collapse collapse-arrow">
                                <input type="radio" name="my-accordion-2" x-bind:checked="checked" @click="checked = !checked" /> 
                                <div class="collapse-title text-xl font-medium" @click="checked = !checked">
                                    <p class="text-sm text-gray-600 font-medium">{{ Auth::user()->name }}</p>
                                    <p class="text-xs text-gray-400">{{ Auth::user()->email }}</p>
                                </div>
                                <div class="collapse-content"> 
                                    <a href="{{ route('profile.show') }}" wire:navigate>
                                        {{ __('Profile') }}
                                    </a>
                                    <div class="divider"></div> 
                                    {{-- orders --}}
                                <a href="{{ route('order-management') }}" wire:navigate>
                                    {{ __('Orders') }}
                                </a>
                                <div class="divider"></div> 
                                {{-- wishlist --}}
                                @mobile
                                <div>
                                   <livewire:UserWishlist device="mobile" />  
                                </div>
                                @endmobile
                               
                                <div class="divider"></div> 
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
            
                                    <a href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </a>
                                </div>
                            </div>
                            
                              {{--  --}}
                            
                        </div>
                    </li>
                    @else
                        <li><a href="{{ route('login') }}" wire:navigate class="block p-4 hover:bg-gray-100 text-black">Login</a></li>
                    @endif
                    {{-- profile test/ --}}
                    <li><a href="{{ route('home') }}" wire:navigate class="block p-4 hover:bg-gray-100 text-black">Home</a></li>
                    <li><a href="{{ route('productList') }}" wire:navigate class="block p-4 hover:bg-gray-100 text-black">
                        {{ __('Products') }}
                    </a></li>
                    <li><livewire:CategoriesDropdown device='mobile'/></li>
                    
                    <li><a href="{{ route('contact') }}" class="block p-4 hover:bg-gray-100 text-black" wire:navigate>Contact</a></li>
                    <li><a href="{{ route('about') }}" class="block p-4 hover:bg-gray-100 text-black" wire:navigate>About</a></li>
                    @auth
                     
                    @if(Auth::user()->canAccessPanel(new Filament\Panel))
                           <li><a href="{{ route('admin') }}" class="p-4 text-black hover:text-white hover:bg-amber-400 transition duration-150 ease-out hover:ease-in" target="_blank">Admin</a></li>
                       @endif
                   @endauth
                </ul>
            </div>
        </div>

        <!-- Desktop Navbar -->
        <div class="flex justify-around">
            
            <div class="hidden md:flex justify-center items-center">
                <!-- Logo -->
                <a href="#" class="p-4 text-lg font-semibold text-gray-800">Logo</a>
                
                <!-- Navigation Links -->
                <ul class="flex items-center mx-2">
                    <li>
                        <a href="{{ route('home') }}" wire:navigate class="p-4 text-accent hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in {{ request()->routeIs('home') ? 'bg-accent text-white' : '' }}">
                            {{ __('Home') }}
                        </a>
        
                        
                        
                    </li>
                    <li><a href="{{ route('productList') }}" wire:navigate class="p-4 text-accent hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in {{ request()->routeIs('productList') ? 'bg-accent text-white' : '' }}">
                        {{ __('Products') }}
                    </a></li>
                    <li><livewire:CategoriesDropdown device='desktop'/></li>
                    <li><a href="{{ route('about') }}" class="p-4 text-accent hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in" wire:navigate>About</a></li>
                    <li><a href="{{ route('contact') }}" class="p-4 text-accent hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in" wire:navigate>Contact</a></li>
                    
                     @auth
                    @desktop 
                    <li> 
                        <livewire:UserWishlist device="desktop" />
                    </li>
                    @enddesktop
                     @if(Auth::user()->canAccessPanel(new Filament\Panel))
                            <li><a href="{{ route('admin') }}" class="p-4 text-accent hover:text-white hover:bg-accent transition duration-150 ease-out hover:ease-in" target="_blank">Admin</a></li>
                        @endif
                    @endauth
                </ul>
                {{-- livewire search component --}}
                <livewire:search />
                {{-- end livewire search component --}}
                
                <div class="ml-4">
                 <!-- Cart Modal Structure -->
                 @if(Auth::check())
                 @desktop
                <div class="relative"> <livewire:ShoppingCart /></div>
                @enddesktop
                {{-- end Cart Modal Structure --}}
               
                
            </div>
            {{--  --}}
            

                <div class="hidden sm:flex sm:items-center sm:ms-6">
                    <!-- Teams Dropdown -->
                    {{-- @if (Laravel\Jetstream\Jetstream::hasTeamFeatures())
                        <div class="ms-3 relative">
                            <x-dropdown align="right" width="60">
                                <x-slot name="trigger">
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->currentTeam->name }}
            
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 15L12 18.75 15.75 15m-7.5-6L12 5.25 15.75 9" />
                                            </svg>
                                        </button>
                                    </span>
                                </x-slot>
            
                                <x-slot name="content">
                                    <div class="w-60">
                                        <!-- Team Management -->
                                        <div class="block px-4 py-2 text-xs text-gray-400">
                                            {{ __('Manage Team') }}
                                        </div>
            
                                        <!-- Team Settings -->
                                        <x-dropdown-link href="{{ route('teams.show', Auth::user()->currentTeam->id) }}">
                                            {{ __('Team Settings') }}
                                        </x-dropdown-link>
            
                                        @can('create', Laravel\Jetstream\Jetstream::newTeamModel())
                                            <x-dropdown-link href="{{ route('teams.create') }}">
                                                {{ __('Create New Team') }}
                                            </x-dropdown-link>
                                        @endcan
            
                                        <!-- Team Switcher -->
                                        @if (Auth::user()->allTeams()->count() > 1)
                                            <div class="border-t border-gray-200"></div>
            
                                            <div class="block px-4 py-2 text-xs text-gray-400">
                                                {{ __('Switch Teams') }}
                                            </div>
            
                                            @foreach (Auth::user()->allTeams() as $team)
                                                <x-switchable-team :team="$team" />
                                            @endforeach
                                        @endif
                                    </div>
                                </x-slot>
                            </x-dropdown>
                        </div>
                    @endif --}}
                    <!-- Settings Dropdown -->
                    <div class="ms-3 relative">
                        <x-dropdown align="right" width="48">
                            <x-slot name="trigger">
                                @if (Laravel\Jetstream\Jetstream::managesProfilePhotos())
                                    <button class="flex text-sm border-2 border-transparent rounded-full focus:outline-none focus:border-gray-300 transition">
                                        <img class="h-8 w-8 rounded-full object-cover" src="{{ Auth::user()->profile_photo_url }}" alt="{{ Auth::user()->name }}" />
                                    </button>
                                @else
                                    <span class="inline-flex rounded-md">
                                        <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-500 bg-white hover:text-gray-700 focus:outline-none focus:bg-gray-50 active:bg-gray-50 transition ease-in-out duration-150">
                                            {{ Auth::user()->name }}
            
                                            <svg class="ms-2 -me-0.5 h-4 w-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M19.5 8.25l-7.5 7.5-7.5-7.5" />
                                            </svg>
                                        </button>
                                    </span>
                                @endif
                            </x-slot>
            
                            <x-slot name="content">
                                <!-- Account Management -->
                                <div class="block px-4 py-2 text-xs text-gray-400">
                                    {{ __('Manage Account') }}
                                </div>
            
                                <x-dropdown-link href="{{ route('profile.show') }}" wire:navigate>
                                    {{ __('Profile') }}
                                </x-dropdown-link>
            
                                @if (Laravel\Jetstream\Jetstream::hasApiFeatures())
                                    <x-dropdown-link href="{{ route('api-tokens.index') }}">
                                        {{ __('API Tokens') }}
                                    </x-dropdown-link>
                                @endif
            
                                <div class="border-t border-gray-200"></div>
            
                                {{-- orders --}}
                                <x-dropdown-link href="{{ route('order-management') }}" wire:navigate>
                                    {{ __('Orders') }}
                                </x-dropdown-link>
                                
                                <!-- Authentication -->
                                <form method="POST" action="{{ route('logout') }}" x-data>
                                    @csrf
            
                                    <x-dropdown-link href="{{ route('logout') }}"
                                             @click.prevent="$root.submit();">
                                        {{ __('Log Out') }}
                                    </x-dropdown-link>
                                </form>
                            </x-slot>
                        </x-dropdown>
                    </div>
                </div>

                {{-- else show login button --}}
                @else
                <a href="{{ route('register') }}" class="btn btn-primary">Sign up</a>
                <a href="{{ route('login') }}" class="btn btn-primary">Log in</a>

                @endif

                
                
                {{--  --}}
            </div>
            
        </div>
    </div>   
    <livewire:notifications />
</nav>
