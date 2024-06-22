<div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 py-12">
    @if (session()->has('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="bg-white shadow-md rounded-lg px-8 py-8 mb-4">
        <h2 class="text-2xl font-bold text-gray-700 mb-6">Contact Us</h2>
    <p class="text-gray-600 mb-6">We'd love to hear from you! Whether you have a question about our products, need assistance, or just want to share your feedback, our team is ready to help. Please fill out the form below, and we'll get back to you as soon as possible.</p>

        
        <form wire:submit.prevent="submit">
            @csrf

            <div class="mb-4">
                <label for="name" class="block text-gray-700 text-sm font-bold mb-2">Name</label>
                <input id="name" type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model="name">
                @error('name') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="email" class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input id="email" type="email" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model="email" required>
                @error('email') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label for="subject" class="block text-gray-700 text-sm font-bold mb-2">Subject</label>
                <input id="subject" type="text" class="form-input mt-1 block w-full rounded-md border-gray-300 shadow-sm" wire:model="subject" required>
                @error('subject') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label for="message" class="block text-gray-700 text-sm font-bold mb-2">Message</label>
                <textarea id="message" class="form-textarea mt-1 block w-full rounded-md border-gray-300 shadow-sm" rows="6" wire:model="message" required></textarea>
                @error('message') <p class="text-red-500 text-xs italic">{{ $message }}</p> @enderror
            </div>

            <div class="flex items-center justify-end">
                <button type="submit" class="btn btn-wide btn-accent btn-outline">Send</button>
            </div>
        </form>
    </div>

    <div class="bg-white shadow-md rounded-lg px-8 py-8 mb-4 mt-8">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Other Ways to Contact Us</h3>
        
        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Email</h4>
            <p class="text-gray-600">support@example.com</p>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Phone</h4>
            <p class="text-gray-600">+1 (123) 456-7890</p>
            <p class="text-gray-600">Mon-Fri, 9am-5pm</p>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Address</h4>
            <p class="text-gray-600">123 Example Street, City, State, 12345</p>
        </div>


        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Social Media</h4>
            <p class="text-gray-600">Follow us on:</p>
            <div class="flex space-x-4 mt-2">
                <a href="https://twitter.com" target="_blank" class="text-blue-500 hover:text-blue-700"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M24 4.557c-.883.392-1.832.656-2.828.775 1.017-.609 1.798-1.574 2.165-2.724-.951.564-2.005.974-3.127 1.195-.897-.957-2.178-1.555-3.594-1.555-3.179 0-5.515 2.966-4.797 6.045-4.091-.205-7.719-2.165-10.148-5.144-1.29 2.213-.669 5.108 1.523 6.574-.806-.026-1.566-.247-2.229-.616-.054 2.281 1.581 4.415 3.949 4.89-.693.188-1.452.232-2.224.084.626 1.956 2.444 3.379 4.6 3.419-2.07 1.623-4.678 2.348-7.29 2.04 2.179 1.397 4.768 2.212 7.548 2.212 9.142 0 14.307-7.721 13.995-14.646.962-.695 1.797-1.562 2.457-2.549z"></path></svg></a>
               <a href="https://youtube.com" target="_blank" class="text-red-500 hover:text-pink-700">
                <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"></path></svg></a>
                <a href="https://facebook.com" target="_blank" class="text-blue-400 hover:text-blue-600"><svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" class="fill-current"><path d="M9 8h-3v4h3v12h5v-12h3.642l.358-4h-4v-1.667c0-.955.192-1.333 1.115-1.333h2.885v-5h-3.808c-3.596 0-5.192 1.583-5.192 4.615v3.385z"></path></svg></a>
                <a href="https://linkedin.com" target="_blank" class="text-blue-700 hover:text-blue-900">li</a>
            </div>
        </div>

        <div class="mb-4">
            <h4 class="text-lg font-semibold text-gray-700">Frequently Asked Questions</h4>
            <p class="text-gray-600">Visit our <a href="/" class="text-blue-500 hover:underline">FAQ page</a> for quick answers to common questions.</p>
        </div>
    </div>

    <div class="bg-white shadow-md rounded px-8 py-8 mb-4 mt-8">
        <h3 class="text-xl font-bold text-gray-700 mb-4">Find Us on the Map</h3>
        <div class="w-full h-64 bg-gray-200 rounded-md">
            <!-- Embed Google Map here -->
            <iframe src="https://www.google.com/maps/embed?!1m18!1m12!1m3!1d0!2d0!3d0!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0!5e0!3m2!1sen!2s!4v1616539289291!5m2!1sen!2s" width="100%" height="100%" frameborder="0" style="border:0;" allowfullscreen="" aria-hidden="false" tabindex="0"></iframe>
        </div>
    </div>
</div>
