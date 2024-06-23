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

    // Listeners
    protected $listeners = ['RemovedFromWishlist' => 'render'];

    public function mount($device)
    {
        $this->device = $device;
    }

    // add to wishlist
    #[On('add-to-wishlist')]
    public function addToWishlist($product_id)
    {
        // if product is not in wishlist or cart
        if (!Wishlist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists() && !Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists()) {
            $wishlist = new Wishlist();
            $wishlist->user_id = Auth::user()->id;
            $wishlist->product_id = $product_id;
            $wishlist->save();
            Notification::make()
                ->title('Item added to wishlist')
                ->success()
                //     ->icon('heroicon-m-check-circle')
                // ->iconColor('success')
                ->send();
            // Dispatch the event
            $this->dispatch('productAddedToWishlist', $product_id);
        } else {
            // if product is in cart
            if (Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists()) {
                // code...
                Notification::make()
                    ->title('Item already exists in cart')
                    ->warning()
                    ->send();
            } else {
                // code...
                // \Log::info("Item $product_id already in wishlist");
                // Notification::make()
                //     ->title('Item already exists in wishlist')
                //     ->warning()
                //     ->send();
                $this->removeFromWishlist($product_id);
            }
        }
    }

    // remove from wishlist
    #[On('remove-from-wishlist')]
    public function removeFromWishlist($product_id)
    {
        $wishlist = Wishlist::where('user_id', Auth::user()->id)->where('product_id', $product_id)->first();
        if ($wishlist) {
            $wishlist->delete();
        }

        // Notification
        Notification::make()
            ->title('Item removed from wishlist')
            ->color('danger')
            ->icon('heroicon-o-check-circle')
            ->iconColor('success')
            ->send();
        // Dispatch the event
        $this->dispatch('RemovedFromWishlist', $product_id);
    }

    // render
    public function render()
    {
        // Check if user is logged in and fetch wishlist
        $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        // \Log::info($this->wishlist);
        return view('livewire.user-wishlist');
    }
}
