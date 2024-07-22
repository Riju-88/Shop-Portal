{{-- root container --}}
<div class="">

{{--  section 1--}}
<section class="text-gray-600 body-font">
    <div class="container px-5 py-8 lg:py-24 mx-auto flex flex-wrap">
      <div class="flex flex-wrap -mx-4 mt-auto mb-auto w-full lg:w-1/2  content-start md:content-center lg:content-start ">
        <div class="w-full sm:p-4 px-4 mb-6">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">My Goal</h1>
          <div class="leading-relaxed">{{config('app.name')}} is more than just an e-commerce web application, it represents my journey in mastering Laravel. This project is a pivotal addition to my portfolio, demonstrating my capability to create feature-rich, responsive, and user-friendly web applications.</div>
        </div>
       
      </div>
      <div class="lg:w-1/2 w-full overflow-hidden mt-6 sm:mt-0 ">
        <img class="object-cover object-center w-full rounded-lg aspect-video" src="{{ asset('storage/about-images/' . 'goal.svg') }}" alt="stats">
      </div>
    </div>
  </section>
{{--  section 1--}}


{{--  section 2--}}
<section class="text-gray-600 body-font">
    <div class="container px-5 py-8 lg:py-24 mx-auto flex flex-col-reverse lg:flex-row flex-wrap">
      <div class="lg:w-1/2 w-full overflow-hidden mt-6 sm:mt-0 ">
            <img class="object-cover object-center w-full rounded-lg aspect-video" src="{{ asset('storage/about-images/' . 'blueprint.svg') }}" alt="stats">
          </div>
          <div class="flex flex-wrap -mx-4 mt-auto mb-auto w-full lg:w-1/2  content-start md:content-center lg:content-start ">
            <div class="w-full sm:p-4 px-4 mb-6">
            <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">The Beginning</h1>
          <div class="leading-relaxed"><p>The idea for {{config('app.name')}} stemmed from my ambition to take on more complex projects. After successfully creating a discussion platform/forum as my first Laravel project, I decided to challenge myself further. Thus, {{config('app.name')}} was born – a comprehensive e-commerce application designed to showcase my development skills.</p></div>
        </div>
       
      </div>
     
    </div>
  </section>
{{--  section 2--}}


{{--  section 3 --}}

<section class="text-gray-600 body-font">
    <div class="container px-5 py-8 lg:py-24 mx-auto flex flex-wrap">
      <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Features</h1>
      <div class="flex flex-wrap w-full">
        <div class="lg:w-2/5 md:w-1/2 md:pr-10 md:py-6">
          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z"></path>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Promotional Carousel</h2>
              <p class="leading-relaxed">Dynamic slides showcasing ongoing promotions.</p>
            </div>
          </div>
          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M22 12h-4l-3 9L9 3l-3 9H2"></path>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Featured Products Section</h2>
              <p class="leading-relaxed">Highlighting top products for easy access.</p>
            </div>
          </div>
          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <circle cx="12" cy="5" r="3"></circle>
                <path d="M12 22V8M5 12H2a10 10 0 0020 0h-3"></path>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Special Promo Feature</h2>
              <p class="leading-relaxed">Discounts on products from specific categories.</p>
            </div>
          </div>
          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Wishlist and Cart</h2>
              <p class="leading-relaxed">Save and purchase your favorite items with ease.</p>
            </div>
          </div>
          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Checkout Options</h2>
              <p class="leading-relaxed">Seamless online/offline payment processing with Razorpay integration.</p>
            </div>
          </div>

          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Contact Form</h2>
              <p class="leading-relaxed">Easy communication through a built-in contact form.</p>
            </div>
          </div>

          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Product Management</h2>
              <p class="leading-relaxed">Nested categories, product filters, and reviews for a comprehensive shopping experience.</p>
            </div>
          </div>

          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Admin Panel</h2>
              <p class="leading-relaxed">Efficient management of the store through a secure admin interface.</p>
            </div>
          </div>

          {{-- end feature --}}

          {{-- feature --}}
          <div class="flex relative pb-12">
            <div class="h-full w-10 absolute inset-0 flex items-center justify-center">
              <div class="h-full w-1 bg-gray-200 pointer-events-none"></div>
            </div>
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M20 21v-2a4 4 0 00-4-4H8a4 4 0 00-4 4v2"></path>
                <circle cx="12" cy="7" r="4"></circle>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">User Authentication</h2>
              <p class="leading-relaxed">Secure login and registration powered by Jetstream.</p>
            </div>
          </div>

          {{-- end feature --}}

          {{-- last feature --}}
          <div class="flex relative">
            <div class="flex-shrink-0 w-10 h-10 rounded-full bg-indigo-500 inline-flex items-center justify-center text-white relative z-10">
              <svg fill="none" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" class="w-5 h-5" viewBox="0 0 24 24" data-darkreader-inline-stroke="" style="--darkreader-inline-stroke: currentColor;">
                <path d="M22 11.08V12a10 10 0 11-5.93-9.14"></path>
                <path d="M22 4L12 14.01l-3-3"></path>
              </svg>
            </div>
            <div class="flex-grow pl-4">
              <h2 class="font-medium title-font text-sm text-gray-900 mb-1 tracking-wider">Responsive UI</h2>
              <p class="leading-relaxed">A beautiful and responsive design using Tailwind CSS and DaisyUI.</p>
            </div>
          </div>
          {{-- end last feature --}}
        </div>

        <div class="lg:w-3/5 md:w-1/2 w-full overflow-hidden md:mt-0 mt-12 ">
            <img class="object-contain object-center w-full rounded-lg " src="{{ asset('storage/about-images/' . 'features.svg') }}" alt="stats">
          </div>
       
      </div>
    </div>
  </section>
{{--  section 3 --}}

{{--  section 4 --}}

<section class="text-gray-600 body-font">
  <div class="container px-5 py-8 lg:py-24 mx-auto flex flex-col-reverse lg:flex-row flex-wrap">
    <div class="lg:w-1/2 w-full overflow-hidden mt-6 sm:mt-0 ">
          <img class="object-contain object-center w-full rounded-lg aspect-video" src="{{ asset('storage/about-images/' . 'journey.svg') }}" alt="stats">
        </div>
        <div class="flex flex-wrap -mx-4 mt-auto mb-auto w-full lg:w-1/2  content-start md:content-center lg:content-start ">
          <div class="w-full sm:p-4 px-4 mb-6">
          <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">The Journey</h1>
        <div class="leading-relaxed"><p>I crafted {{config('app.name')}} independently, utilizing resources from Google, Stack Overflow, YouTube, and other online sources. The development process was a learning experience, and it showcases my problem-solving skills and perseverance.</p></div>
      </div>
     
    </div>
   
  </div>
</section>
{{--  section 4 --}}

{{-- section 5 --}}
<section class="text-gray-600 body-font">
  <div class="container px-5 py-8 lg:py-24 mx-auto flex flex-wrap">
    <div class="flex flex-wrap -mx-4 mt-auto mb-auto w-full lg:w-1/2  content-start md:content-center lg:content-start ">
      <div class="w-full sm:p-4 px-4 mb-6">
          <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Technology Stack</h1>
        <div class="leading-relaxed"><p>{{config('app.name')}} leverages the power of the TALL Stack (Tailwind CSS, Alpine.js, Laravel, Livewire), along with Filament and DaisyUI. These technologies contribute to a robust, efficient, and visually appealing application.</p></div>
      </div>
     
    </div>
    <div class="lg:w-1/2 w-full overflow-hidden mt-6 sm:mt-0 ">
      <img class="object-contain object-center w-full rounded-lg aspect-video" src="{{ asset('storage/about-images/' . 'tech_stack.svg') }}" alt="stats">
    </div>
  </div>
</section>
{{-- section 5 --}}

{{--  section 6 --}}
<section class="text-gray-600 body-font">
  <div class="container px-5 py-8 lg:py-24 mx-auto flex flex-col-reverse lg:flex-row flex-wrap">
    <div class="lg:w-1/2 w-full overflow-hidden mt-6 sm:mt-0 ">
          <img class="object-contain object-center w-full  aspect-video rounded-lg" src="{{ asset('storage/about-images/' . 'future_plan.svg') }}" alt="stats">
        </div>
        <div class="flex flex-wrap -mx-4 mt-auto mb-auto w-full lg:w-1/2  content-start md:content-center lg:content-start ">
          <div class="w-full sm:p-4 px-4 mb-6">
          <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Future Plans</h1>
        <div class="leading-relaxed"> <p>While the current version of {{config('app.name')}} is feature-rich, there are plans to fix any bugs and potentially add more features. However, my primary focus will be on hosting and showcasing this project.</p></div>
      </div>
     
    </div>
   
  </div>
</section>
{{--  section 6 --}}

{{--  section 7 --}}
<section class="text-gray-600 body-font">
  <div class="container px-5 py-8 lg:py-24 mx-auto flex flex-wrap">
    <div class="flex flex-wrap -mx-4 mt-auto mb-auto w-full lg:w-1/2  content-start md:content-center lg:content-start">
      <div class="w-full sm:p-4 px-4 mb-6">
          <h1 class="title-font sm:text-4xl text-3xl mb-4 font-medium text-gray-900">Get in Touch</h1>
        <div class="leading-relaxed"><p>For any inquiries or feedback, please use the contact form on our <a class="link text-blue-500" href="{{ route('contact') }}" wire:navigate>Contact Us</a> page. Simply provide your name, email, and message, and it will be sent directly to the admin.</p></div>
      </div>
     
    </div>
    <div class="lg:w-1/2 w-full overflow-hidden mt-6 sm:mt-0 ">
      <img class="object-contain object-center w-full rounded-lg aspect-video filter saturate-200" src="{{ asset('storage/about-images/' . 'contact.svg') }}" alt="stats">
    </div>
  </div>
</section>
{{--  section 7 --}}

{{-- root container --}}
</div>