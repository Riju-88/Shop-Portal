<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('test') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
        <livewire:Counter/>
       <h2><a href="{{ route('dashboard') }}" target="_blank" class="btn btn-primary">Login</a></h2>
       <h2><a href="{{ route('register') }}" target="_blank" class="btn btn-primary">Register</a></h2>
        </div>
    </div>
</x-app-layout>
