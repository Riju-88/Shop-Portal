<?php

use App\Http\Controllers\ProductController;
use App\Http\Controllers\RazorpayController;
use App\Livewire\Categories;
use App\Livewire\Checkout;
use App\Livewire\Home;
use App\Livewire\OrderManagement;
use App\Livewire\ProductDetail;
use App\Livewire\ProductList;
use App\Livewire\RazorpayGateway;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
 * |--------------------------------------------------------------------------
 * | Web Routes
 * |--------------------------------------------------------------------------
 * |
 * | Here is where you can register web routes for your application. These
 * | routes are loaded by the RouteServiceProvider and all of them will
 * | be assigned to the "web" middleware group. Make something great!
 * |
 */

// Route::get('/', function () {
//     return view('welcome');
// });

Route::redirect('/adminpanel', '/admin')->name('admin');  // redirect to admin dashboard(not the best way to do it. But it works. Couldn't find a way to make route name in filament admin panel.)

Route::get('/test', function () {
    return view('razorpay.test');
})->name('razorpay.test');
// razorpay test

Route::middleware([
    'auth:sanctum',
    config('jetstream.auth_session'),
    'verified',
])->group(function () {
    Route::get('/dashboard', function () {
        return view('dashboard');
    })->name('dashboard');  // using livewire home instead of this

    Route::get('/manage-orders', OrderManagement::class)->name('order-management');

    // checkout
    Route::get('checkout', Checkout::class)->name('checkout');

    // make this route available only if session has formState
    // razorpay
    Route::get('razorpay/payment', function (Request $request) {
        if ($request->session()->has('formState')) {
            return view('razorpay.index');
        } else {
            return redirect()->back();
        }
    })->name('razorpay.index');

    Route::post('razorpay/payment', [RazorpayController::class, 'store'])->name('razorpay.payment.store');
});

// home
Route::get('/', Home::class)->name('home');
// products
// Route::get('/products', [ProductController::class, 'index'])->name('products.index');

// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/products', ProductList::class)->name('productList');
// Route::get('/products/{product}', [ProductController::class, 'show'])->name('products.show');
Route::get('/product/{productId}', ProductDetail::class)->name('product.detail');

// categories
Route::get('/categories/{slug}', Categories::class)->name('categories');
// Route::name('razorpay.')
//     ->controller(RazorpayController::class)
//     ->prefix('razorpay')
//     ->group(function () {
//         Route::view('payment', 'razorpay.index')->name('create.payment');
//         Route::post('handle-payment', 'handlePayment')->name('make.payment');
//     });

//     Route::view('checkout', 'razorpay.index')->name('create.payment');

// Route::get('razorpay/gateway', RazorpayGateway::class)->name('razorpay.gateway');
// Route::post('razorpay-live-payment', [RazorpayGateway::class, 'store'])->name('razorpay.livepayment.store');
