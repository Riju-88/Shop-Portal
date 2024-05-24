<?php

namespace App\Livewire;

use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Livewire\Component;

class OrderManagement extends Component
{
    public $orders;
    public $products;

    public function mount()
    {
        $this->orders = Order::where('user_id', Auth::user()->id)
            ->orderByRaw("FIELD(status, 'pending', 'delivered', 'cancelled')")
            ->orderBy('created_at', 'desc')
            ->get();
    }

    public function deleteOrder($orderId)
    {
        // update product stock before deleting
        $order = Order::find($orderId);
        if ($order && $order->status == 'pending') {
            // Decode the JSON items field
            $items = json_decode($order->items, true);

            // Update the product quantities
            foreach ($items as $item) {
                $product = Product::find($item['product_id']);
                if ($product) {
                    $product->quantity += $item['quantity'];
                    $product->save();
                }
            }
            // delete order

            $order->delete();

            $this->orders = Order::where('user_id', Auth::user()->id)->get();
        }
    }

    public function render()
    {
        $this->orders = Order::where('user_id', Auth::user()->id)->get();
        $this->products = Product::all();
        return view('livewire.order-management');
    }
}
