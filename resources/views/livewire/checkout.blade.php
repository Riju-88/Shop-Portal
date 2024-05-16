<div>
    {{-- Be like water. --}}
    {{-- form --}}
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
        {{-- set span styles to initial --}}



        <form wire:submit="create" x-ref="form">

            <div class="fi-form-group my-6">

                {{ $this->form }}
            </div>


        </form>

        <x-filament-actions::modals />
        <livewire:notifications />

    </div>
</div>
