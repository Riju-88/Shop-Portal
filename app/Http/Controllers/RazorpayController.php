<?php

namespace App\Http\Controllers;

use App\Mail\OrderCreated;
use App\Models\Cart;
use App\Models\Order;
use App\Models\Payment;
use App\Models\PaymentMethod;
use App\Models\Product;
use App\Models\Shipping;
use App\Models\User;
use Filament\Notifications\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;
use Razorpay\Api\Api;
use Exception;

class RazorpayController extends Controller
{
    public function store(Request $request)
    {
        $input = $request->all();
         // Verify CSRF token
         if (!Session::token() == $input['_token']) {
            Session::put('error', 'CSRF token mismatch');
            return redirect()->back();
        }
        $api = new Api(env('RAZORPAY_API_KEY'), env('RAZORPAY_API_SECRET'));
        // dd($input);
        $payment = $api->payment->fetch($input['razorpay_payment_id']);
        if (count($input) && !empty($input['razorpay_payment_id'])) {
            try {
                $response = $api->payment->fetch($input['razorpay_payment_id'])->capture(array('amount' => $payment['amount']));
                $payment = Payment::create([
                    'r_payment_id' => $response['id'],
                    'method' => $response['method'],
                    'currency' => $response['currency'],
                    'user_email' => $response['email'],
                    'amount' => $response['amount'] / 100,
                    'json_response' => json_encode((array) $response)
                ]);

                if ($response['status'] == 'captured') {
                    DB::transaction(function () {
                        // create order
                        // $order = Order::create(session('formState'));

                        $order = new Order();
                        $order->user_id = Auth::user()->id;
                        $order->total_amount = session('formState')['total_amount'];
                        // use user id , timestamp and order_ prefix for order number
                        $order->order_number = 'order_' . Auth::user()->id . '_' . time();
                        $order->status = 'pending';
                        $order->payment_method = PaymentMethod::find(session('formState')['payment_method'])->pay_method_name;

                        $order->payment_status = 'paid';

                        // Retrieve the user's cart items
                        $userId = Auth::user()->id;
                        $cartItems = Cart::where('user_id', $userId)->get();

                        // Format the cart items for storing in the orders table
                        $items = $cartItems->map(function ($item) {
                            return [
                                'product_id' => $item->product_id,
                                'quantity' => $item->quantity,
                            ];
                        });

                        // Store the cart items as JSON in the order
                        $order->items = $items->toJson();

                        // Save the order
                        // $order->save();

                        // update product quantity
                        foreach ($cartItems as $item) {
                            $product = Product::find($item->product_id);
                            $product->quantity -= $item->quantity;
                            $product->save();
                        }

                        // Clear the user's cart
                        Cart::where('user_id', $userId)->delete();

                        // add shipping details
                        $shipping = new Shipping();
                        $shipping->user_id = Auth::user()->id;
                        // get from session

                        $shipping->first_name = session('formState')['first_name'];
                        $shipping->last_name = session('formState')['last_name'];
                        $shipping->shipping_method_id = session('formState')['shipping_method_id'];
                        $shipping->address_line_1 = session('formState')['address_line_1'];
                        $shipping->address_line_2 = session('formState')['address_line_2'];
                        $shipping->city = session('formState')['city'];
                        $shipping->state = session('formState')['state'];
                        $shipping->country = session('formState')['country'];
                        $shipping->postal_code = session('formState')['postal_code'];
                        $shipping->phone_number = session('formState')['phone_number'];
                        $shipping->save();

                        // assign shipping_id to the order
                        $order->shipping_id = $shipping->id;

                        // Save the order
                        $order->save();

                        // Send email to the user
                        Mail::to(Auth::user()->email)->send(new OrderCreated($order));

                        // clear session
                        session()->forget('formState');
                        // Send notification
                        Notification::make()
                            ->title('Order Placed Successfully')
                            ->success()
                            ->send();
                    });
                }
            } catch (Exception $e) {
                \Log::error('Razorpay API Error: ' . $e->getMessage());
                Session::put('error', 'An error occurred while processing the payment. Please try again later.');
                return redirect(route('home'));
            }
        }
        // Session::put('success', ('Payment Successful'));
        return redirect(route('home'));
    }
}
