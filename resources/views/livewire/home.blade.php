<div>
  <div class="py-2 my-6">
         
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 <!-- Carousel -->
                 <div x-data="{ activeSlide: 0, slides: {{ count($promo->image) }}, nextSlide() { this.activeSlide = (this.activeSlide + 1) % this.slides }, prevSlide() { this.activeSlide = (this.activeSlide - 1 + this.slides) % this.slides }, startAutoSlide() { setInterval(() => { this.nextSlide() }, 5000) } }" x-init="startAutoSlide" class="carousel w-full my-6">
                  @forelse($promo->image as $index => $image)
                  <div x-show="activeSlide === {{ $index }}" class="carousel-item relative w-full" style="height: 0; padding-bottom: 56.25%;"  
                  x-transition:enter="transition ease-in-out duration-500 transform"
                  x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition linear duration-500 transform" x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 translate-x-full"
                  >
                      <img src="{{ asset('storage/' . $image) }}" class="absolute top-0 left-0 w-full h-full object-cover" />
                      <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                          <button @click="prevSlide" class="btn btn-circle">❮</button>
                          <button @click="nextSlide" class="btn btn-circle">❯</button>
                      </div>
                  </div>
                  @empty
                  <div x-show="activeSlide === 1" class="carousel-item relative w-full" style="height: 0; padding-bottom: 56.25%;"  x-transition:enter="transition ease-in-out duration-500 transform"
                  x-transition:enter-start="opacity-0 translate-x-full" x-transition:enter-end="opacity-100 translate-x-0"
                  x-transition:leave="transition linear duration-500 transform" x-transition:leave-start="opacity-100 translate-x-0"
                  x-transition:leave-end="opacity-0 translate-x-full">
                      <img src="https://source.unsplash.com/random/?fruit" class="absolute top-0 left-0 w-full h-full object-cover" />
                      <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                          <button @click="prevSlide" class="btn btn-circle">❮</button>
                          <button @click="nextSlide" class="btn btn-circle">❯</button>
                      </div>
                  </div>
                  @endif
              </div>
              
                
                 <!-- Featured Products -->
                 <div class="flex justify-between my-4">
                  <div class="text-2xl font-bold bg-accent px-4 py-2 tracking-tight text-gray-200 rounded-e-full">Featured Products</div>
              </div>

              {{-- render featured products component based on screen size --}}
                <div x-data="{ isLargeScreen: window.innerWidth > 600 }" x-on:resize.window="isLargeScreen = window.innerWidth > 600">
                  <div x-show="isLargeScreen">
                    <livewire:featured-products device="desktop" />
                  </div>

                  <div x-show="!isLargeScreen">
                    {{--  --}}
                    <livewire:featured-products-mobile device="mobile" />
                    {{--  --}}
                  </div>
                </div>

             
              <!-- end of featured products -->

                 <!--  -->
                 <livewire:notifications />
                 <!--  -->
             </div>
         </div>
     </div>
</div>