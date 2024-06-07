<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Product;
use App\Models\Wishlist;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class UserWishlist extends Component
{
    public $wishlist;
    public $device;

    public function mount($device)
    {
        $this->device = $device;
    }

    #[On('add-to-wishlist')]
    public function addToWishlist($product_id)
    {
        // if product is not in cart
        if (!Wishlist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists() && !Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists()) {
            $wishlist = new Wishlist();
            $wishlist->user_id = Auth::user()->id;
            $wishlist->product_id = $product_id;
            $wishlist->save();
            Notification::make()
                ->title('Item added to wishlist')
                ->success()
                ->send();
        } else {
            \Log::info("Item $product_id already in wishlist");
            Notification::make()
                ->title('Item already exists in wishlist')
                ->warning()
                ->send();
        }
    }

    #[On('remove-from-wishlist')]
    public function removeFromWishlist($product_id)
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();
        if ($wishlist) {
            $wishlist->delete();
        }


        $this->render();
    }

    public function render()
    {
        $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        \Log::info($this->wishlist);
        return view('livewire.user-wishlist');
    }
}
