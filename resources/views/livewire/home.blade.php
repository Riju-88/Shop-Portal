<div>
    {{-- Care about people's approval and you will be their prisoner. --}}
    <div class="py-12">
        <div class="container flex items-center gap-2 mx-auto my-2">
             <h2 class="font-bold text-blue-500 text-2xl"><a href="{{ route('productList') }}" class="link">Products</a>
            </h2>
            <h2 class="font-bold text-emerald-500 text-2xl"><a href="/admin" class="link">Admin Panel</a>
            </h2>
        </div>
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
           
            <div class="bg-white overflow-hidden shadow-xl sm:rounded-lg">
                <!--  -->
                <div class="carousel w-full">
  <div id="slide1" class="carousel-item relative w-full">
    {{-- placeholder urls --}}
    <img src="https://source.unsplash.com/random/?fruit" class="w-full h-96" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide4" class="btn btn-circle">❮</a> 
      <a href="#slide2" class="btn btn-circle">❯</a>
    </div>
  </div> 
  <div id="slide2" class="carousel-item relative w-full">
    <img src="https://source.unsplash.com/random/?snacks" class="w-full h-96" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide1" class="btn btn-circle">❮</a> 
      <a href="#slide3" class="btn btn-circle">❯</a>
    </div>
  </div> 
  <div id="slide3" class="carousel-item relative w-full">
    <img src="https://source.unsplash.com/random/?dishes" class="w-full h-96" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide2" class="btn btn-circle">❮</a> 
      <a href="#slide4" class="btn btn-circle">❯</a>
    </div>
  </div> 
  <div id="slide4" class="carousel-item relative w-full">
    <img src="https://source.unsplash.com/random/?spices" class="w-full h-96" />
    <div class="absolute flex justify-between transform -translate-y-1/2 left-5 right-5 top-1/2">
      <a href="#slide3" class="btn btn-circle">❮</a> 
      <a href="#slide1" class="btn btn-circle">❯</a>
    </div>
  </div>
</div>
                <!--  -->
                <x-welcome />
                <!--  -->
            
                <!--  -->
            </div>
        </div>
    </div>
</div>
