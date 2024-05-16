<x-guest-layout>
       <livewire:Counter/>

       <div class="container flex items-center justify-center mx-auto gap-4 my-6 w-full border-white-200">
         
       <h2><a href="{{ route('register') }}" target="_blank" class="btn btn-info  rounded-full text-2xl">Register</a></h2>
        <h2><a href="{{ route('home') }}" target="_blank" class="btn btn-success rounded-full text-2xl">Login</a></h2>
       </div>
     
</x-guest-layout>
