<?php

namespace App\Livewire;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Wishlist;
use Filament\Notifications\Notification;
use Illuminate\Support\Facades\Auth;
use Livewire\Attributes\On;
use Livewire\Component;

class FeaturedProducts extends Component
{
    public $wishlist;
    public $products;
    public $categories;
    public $promo;
    public $device;

    // Listeners
    protected $listeners = ['wishlist-add-desktop' => 'render', 'wishlist-remove-desktop' => 'render'];

    // Mount
    public function mount($device)
    {
        $this->device = $device;
    }

    //  Add to wishlist desktop
    #[On('wishlist-add-desktop')]
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
            $this->dispatch('reload-component', $product_id);
        } else {
            // if product is in cart
            if (Cart::where('user_id', Auth::user()->id)->where('product_id', $product_id)->exists()) {
                // notification for cart already exists
                Notification::make()
                    ->title('Item already exists in cart')
                    ->warning()
                    ->send();
            } else {
                // if product is in wishlist
                // \Log::info("Item $product_id already in wishlist");
                // Notification::make()
                //     ->title('Item already exists in wishlist')
                //     ->warning()
                //     ->send();
                // call remove from wishlist
                $this->removeFromWishlist($product_id);
            }
        }
    }

    // Remove from wishlist function
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
        $this->dispatch('reload-component', $product_id);
    }

    // Render
    public function render()
    {
        // if user is logged in, get wishlist
        if (Auth::user()) {
            $this->wishlist = Wishlist::where('user_id', Auth::user()->id)->get();
        }

        // get featured products
        $this->products = Product::where('is_featured', 1)->get();
        // get categories
        $this->categories = Category::all();

        return view('livewire.featured-products');
    }
}
