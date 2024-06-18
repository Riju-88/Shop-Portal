<div class="container mx-auto p-6">
    <header class="text-center my-8">
        <h1 class="text-4xl font-bold mb-4">About {{config('app.name')}}</h1>
        <p class="text-lg">Discover the journey and features of {{config('app.name')}}, an innovative e-commerce platform.</p>
    </header>

    <section class="bg-white shadow-lg rounded-lg p-8 mb-8">
        <div class="space-y-16">
            <div class="flex flex-col md:flex-row items-center md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">My Mission</h2>
                </div>
                <div class="md:w-2/3">
                    <p>{{config('app.name')}} is more than just an online store; it represents my journey in mastering Laravel. This project is a pivotal addition to my portfolio, demonstrating my capability to create feature-rich, responsive, and user-friendly web applications.</p>
                </div>
            </div>

            <div class="divider"></div> 

            <div class="flex flex-col md:flex-row-reverse items-center md:space-x-reverse md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">The Beginning</h2>
                </div>
                <div class="md:w-2/3">
                    <p>The idea for {{config('app.name')}} stemmed from my ambition to take on more complex projects. After successfully creating a discussion platform/forum as my first Laravel project, I decided to challenge myself further. Thus, {{config('app.name')}} was born – a comprehensive e-commerce application designed to showcase my development skills.</p>
                </div>
            </div>

            <div class="divider"></div> 
            
            <div class="flex flex-col md:flex-row items-center md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Key Features</h2>
                </div>
                <div class="md:w-2/3">
                    <ul class="list-disc list-inside space-y-2">
                        <li><strong>Promotional Carousel:</strong> Dynamic slides showcasing ongoing promotions.</li>
                        <li><strong>Featured Products Section:</strong> Highlighting top products for easy access.</li>
                        <li><strong>Special Promo Feature:</strong> Discounts on products from specific categories.</li>
                        <li><strong>Wishlist and Cart:</strong> Save and purchase your favorite items with ease.</li>
                        <li><strong>Checkout Options:</strong> Seamless online/offline payment processing with Razorpay integration.</li>
                        <li><strong>Contact Form:</strong> Easy communication through a built-in contact form.</li>
                        <li><strong>Product Management:</strong> Nested categories, product filters, and reviews for a comprehensive shopping experience.</li>
                        <li><strong>Admin Panel:</strong> Efficient management of the store through a secure admin interface.</li>
                        <li><strong>User Authentication:</strong> Secure login and registration powered by Jetstream.</li>
                        <li><strong>Responsive UI:</strong> A beautiful and responsive design using Tailwind CSS and DaisyUI.</li>
                    </ul>
                </div>
            </div>
            
            <div class="divider"></div> 

            <div class="flex flex-col md:flex-row-reverse items-center md:space-x-reverse md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Project Achievements</h2>
                </div>
                <div class="md:w-2/3">
                    <ul class="list-disc list-inside space-y-2">
                        <li><strong>Full-Stack Development:</strong> Successfully built both frontend and backend of a complex e-commerce application.</li>
                        <li><strong>Payment Integration:</strong> Integrated Razorpay for seamless online transactions.</li>
                        <li><strong>Responsive Design:</strong> Ensured a user-friendly experience across all devices using Tailwind CSS and DaisyUI.</li>
                        <li><strong>Authentication & Authorization:</strong> Implemented secure user authentication with Jetstream.</li>
                        <li><strong>Advanced Features:</strong> Developed features like nested categories, product reviews, and filters to enhance the shopping experience.</li>
                        <li><strong>Admin Panel:</strong> Created a comprehensive admin panel for managing the store efficiently.</li>
                        <li><strong>Problem-Solving:</strong> Tackled various development challenges, demonstrating strong problem-solving skills.</li>
                    </ul>
                </div>
            </div>

            <div class="divider"></div> 
            
            <div class="flex flex-col md:flex-row items-center md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">The Journey</h2>
                </div>
                <div class="md:w-2/3">
                    <p>I built {{config('app.name')}} single-handedly, utilizing resources from Google, Stack Overflow, YouTube, and other online sources. The development process was a learning experience, and it showcases my problem-solving skills and perseverance.</p>
                </div>
            </div>

            <div class="divider"></div> 
            
            <div class="flex flex-col md:flex-row-reverse items-center md:space-x-reverse md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Technology Stack</h2>
                </div>
                <div class="md:w-2/3">
                    <p>{{config('app.name')}} leverages the power of the TALL Stack (Tailwind CSS, Alpine.js, Laravel, Livewire), along with Filament and DaisyUI. These technologies contribute to a robust, efficient, and visually appealing application.</p>
                </div>
            </div>

            <div class="divider"></div> 
            
            <div class="flex flex-col md:flex-row items-center md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Future Plans</h2>
                </div>
                <div class="md:w-2/3">
                    <p>While the current version of {{config('app.name')}} is feature-rich, there are plans to fix any bugs and potentially add more features. However, my primary focus will be on hosting and showcasing this project.</p>
                </div>
            </div>
            
            <div class="divider"></div> 

            <div class="flex flex-col md:flex-row-reverse items-center md:space-x-reverse md:space-x-6">
                <div class="md:w-1/3">
                    <h2 class="text-2xl font-semibold mb-4 text-indigo-600">Get in Touch</h2>
                </div>
                <div class="md:w-2/3">
                    <p>For any inquiries or feedback, please use the contact form on our <a class="link text-blue-500" href="{{ route('contact') }}" wire:navigate>Contact Us</a> page. Simply provide your name, email, and message, and it will be sent directly to the admin.</p>
                </div>
            </div>
        </div>
    </section>
</div>