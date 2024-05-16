<div>
    {{-- In work, do what you enjoy. --}}


    <div class="panel panel-default">
        <div class="panel-body">
            <h1 class="text-3xl md:text-5xl font-extrabold text-center uppercase mb-12 bg-gradient-to-r from-indigo-400 via-purple-500 to-indigo-600 bg-clip-text text-transparent ">Razorpay Payment Gateway</h1>
            @if (session()->has('success'))
                <div class="alert alert-success">
                    {{ session()->get('success') }}
                </div>
            @endif
            <div class="text-center flex justify-center align-center my-4"> 
                  <div class="text-center btn rounded-lg btn-primary btn-outline">
                <!-- route('razorpay.make.payment') -->
                <!-- <form action="" method="POST" > -->
                    {{-- action="{{ route('razorpay.livepayment.store') }}" --}}
                <form wire:submit='store' >
                    @csrf 
                 
                      
                        <script src="https://checkout.razorpay.com/v1/checkout.js"
                            data-key="{{ env('RAZORPAY_API_KEY') }}"
                            data-amount="10000"
                            data-buttontext="Pay 100 INR"
                            data-name="{{ config('app.name') }}"
                            data-description="A demo razorpay payment"
                            data-image="https://pic.onlinewebfonts.com/svg/img_517853.png"
                            data-prefill.name="{{ Auth::user()->name }}"
                            data-prefill.email="{{ Auth::user()->email }}"
                            data-theme.color="#ff7529">
                    </script>
                    
                    
                </form>
            </div>
            </div>
        </div>
    </div>
</div>
