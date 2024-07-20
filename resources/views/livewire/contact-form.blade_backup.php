<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8">
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <form wire:submit.prevent="submit" class="bg-white shadow-md rounded px-8 py-8 mb-4">
        @csrf

        <div class="mb-4">
            <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
            <input id="name" type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model="name">
            @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
            <input id="email" type="email" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model="email">
            @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-4">
            <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
            <input id="subject" type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model="subject">
            @error('subject') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="mb-6">
            <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
            <textarea id="message" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="6" wire:model="message"></textarea>
            @error('message') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
        </div>

        <div class="flex items-center justify-end">
            <button type="submit" class="btn btn-wide btn-accent">Send</button>
        </div>
    </form>
    
</div>
