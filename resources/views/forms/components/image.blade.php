<x-dynamic-component
    :component="$getFieldWrapperView()"
    :field="$field"
>
    <div x-data="{ state: $wire.$entangle('{{ $getStatePath() }}') }">
        <!-- Interact with the `state` property in Alpine.js -->
        <x-filament::avatar src='{{ $getStatePath() }}' size="w-16 h-16" class="rounded-full"/>
    </div>
</x-dynamic-component>
