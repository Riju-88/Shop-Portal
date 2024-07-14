<div class="container px-5 py-24 mx-auto">
    <div class="lg:w-4/5 mx-auto sm:px-6 lg:px-8">
        {{-- Authentication Check --}}
        @if (Auth::check())
            <form wire:submit="create" x-ref="form">
                <div class="fi-form-group my-6">
                    {{-- Form Content --}}
                    {{ $this->form }}
                </div>
                <button class="btn btn-primary">
                    {{ $editing ? 'Update' : 'Submit' }}
                </button>
            </form>
        @endif
        <x-filament-actions::modals />
        <livewire:notifications />
    </div>

    <div class="mt-8 flex flex-col mx-4">
        
            <h2 class="text-xl font-bold">Reviews</h2>
    
            @foreach ($reviews as $review)
            <div class="mt-4" wire:key="review-{{ $review->id }}">
                {{-- Check if the product id matches the current product id --}}
                @if ($productId == $review->product_id)
                
                    <h3 class="text-lg font-bold">{{ $review->user->name }}</h3>
                    <div class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</div>
                    <div class="flex items-center mt-2">
                        @for ($i = 0; $i < $review->rating; $i++)
                            <span class="text-yellow-500">⭐️</span>
                        @endfor
                    </div>
                    <p class="mt-2 font-semibold">{{ $review->title }}</p>
                    <p class="mt-2">{!! $review->review !!}</p>
                    <div class="grid grid-cols-3 gap-4 mt-2">
                        @foreach ($review->image as $filePath)
                            <img src="{{ asset('storage/' . $filePath) }}" class="rounded-lg object-contain w-full" alt="" wire:key="image-file-{{ $review->id }}">
                        @endforeach
                    </div>
                    <div class="mt-4">
                        @if (Auth::check())
                            <!-- Edit button for review -->
                            <button wire:click="edit({{ $review->id }})"
                                @click="$refs.form.scrollIntoView({ behavior: 'smooth' })"
                                class="btn btn-primary">Edit
                            </button>
                
                            <!-- Delete Review -->
                            {{ $this->delete(['review_id' => $review->id]) }}
                        @endif
                    </div>
                    {{-- End of auth --}}
                
                
                
                @endif
            </div>
            @endforeach
        
    </div>
    

</div>
