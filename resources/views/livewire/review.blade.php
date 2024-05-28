<div>
    <div class="max-w-5xl mx-auto sm:px-6 lg:px-8">
 @if (Auth::check())
        <form wire:submit="create" x-ref="form">

            <div class="fi-form-group my-6">
                {{-- if auth check --}}
               
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
        <div class="">
            <h2 class="text-xl font-bold">Reviews</h2>

            @foreach ($reviews as $review)
                {{-- if the product id matches the current product id --}}
                @if ($productId == $review->product_id)
                    <div class="mt-4">
                        <h3 class="text-lg font-bold">{{ $review->user->name }}</h3>
                        <div class="text-sm text-gray-500">{{ $review->created_at->format('M d, Y') }}</div>
                        <div class="mt-2">
                            @for ($i = 0; $i < $review->rating; $i++)
                                ⭐️
                            @endfor
                        </div>
                        <p class="mt-2">{{ $review->title }}</p>
                        <p class="mt-2">{!! $review->review !!}</p>
                    </div>
                    <div>
                        @foreach ($review->image as $filePath)
                            <img src="{{ asset('storage/' . $filePath) }}" class="mt-2 max-w-sm" alt="">
                    </div>
                @endforeach
                <div class="mt-4">
                    @if (Auth::check())
                    <!-- edit button for review -->
                    <button wire:click="edit({{ $review->id }})"
                        @click="$refs.form.scrollIntoView({ behavior: 'smooth' })" class="btn btn-primary">Edit</button>

                    <!-- <button wire:click="delete({{ $review->id }})" class="btn btn-error">Delete</button> -->


                    {{-- Delete Review --}}
                    <!-- Open the modal using ID.showModal() method -->
                    {{ ($this->delete)(['review_id' => $review->id]) }}


                    @endif


                    {{--  --}}


                </div>
            @endif
            @endforeach
        </div>
    </div>
</div>
