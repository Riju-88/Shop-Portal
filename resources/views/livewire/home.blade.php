<div>
  <div class="py-2">
         
         <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            
             <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                 <!--  -->
                 <div class="carousel w-full">
                  @forelse($promo->image as $index => $image)
                  <div id="slide{{ $index }}" class="carousel-item relative w-full">
                    {{-- placeholder urls --}}
                    <img src="{{ asset('storage/' . $image) }}" class="w-full h-screen" />
                    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
                      <a href="#slide{{ $index == 0 ? count($promo->image) - 1 : $index - 1 }}" class="btn btn-circle">❮</a> 
                      <a href="#slide{{ $index == count($promo->image) - 1 ? 0 : $index + 1 }}" class="btn btn-circle">❯</a>
                    </div>
                  </div> 
  
  @empty
  <div id="slide1" class="carousel-item relative w-full">
    {{-- placeholder urls --}}
    <img src="https://source.unsplash.com/random/?fruit" class="w-full h-screen" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide4" class="btn btn-circle">❮</a> 
      <a href="#slide2" class="btn btn-circle">❯</a>
    </div>
  </div> 
  @endif
 </div>
                 <!-- Featured Products -->
                 @php
    $useragent = $_SERVER['HTTP_USER_AGENT'];
    $iPod = stripos($useragent, "iPod");
    $iPad = stripos($useragent, "iPad");
    $iPhone = stripos($useragent, "iPhone");
    $Android = stripos($useragent, "Android");
    $iOS = stripos($useragent, "iOS");
    $DEVICE = ($iPod || $iPad || $iPhone || $Android || $iOS);
@endphp

@if (!$DEVICE)
    <!-- What you want for all non-mobile devices. -->
    <livewire:featured-products device="desktop" />
@else
    <!-- What you want for all mobile devices. -->
    <livewire:featured-products device="mobile" />
@endif

             
<!-- end of featured products -->

                 <!--  -->
                 <livewire:notifications />
                 <!--  -->
             </div>
         </div>
     </div>
</div>