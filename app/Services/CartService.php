<?php
namespace App\Services;

use App\Models\Cart;
use App\Models\CartProduct;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Str;

class CartService
{
    // Get the current cart, handling both authenticated and guest users
    public function getCart(): Cart
    {
        if (Auth::check()) {
            return $this->getUserCart();
        }

        return $this->getGuestCart();
    }

    // Get cart for authenticated user
    protected function getUserCart(): Cart
    {
        // First try to get by user ID
        $cart = Cart::where('user_id', Auth::id())
            ->first();

        // If not found, try to find by session ID and convert to user cart
        if (!$cart) {
            $sessionId = Session::get('cart_session_id');

            if ($sessionId) {
                $cart = Cart::where('session_id', $sessionId)
                    ->first();

                if ($cart) {
                    // Convert guest cart to user cart
                    $cart->update([
                        'user_id' => Auth::id(),
                        'session_id' => null
                    ]);
                }
            }
        }

        // Create new cart if still not found
        return $cart ?? Cart::create([
            'user_id' => Auth::id()
        ]);
    }

    // Get cart for guest user
    protected function getGuestCart(): Cart
    {
        // Get id from session or create a new id
        $sessionId = Session::get('cart_session_id', function () {
            $id = Str::uuid();
            Session::put('cart_session_id', $id);
            return $id;
        });
        // get cart with id or create a new one
        return Cart::firstOrCreate(
            ['session_id' => $sessionId],
            ['session_id' => $sessionId]
        );
    }

    // Add item to cart (unchanged from previous version)
    public function addItem($productId, $quantity = 1): void
    {
        $cart = $this->getCart();

        $existingItem = $cart->items()->where('product_id', $productId)->first();

        if ($existingItem) {
            $existingItem->update(['quantity' => $existingItem->quantity + $quantity]);
        } else {
            // create a new product
            CartProduct::create([
                'cart_id' => $cart->id,
                'product_id' => $productId,
                'quantity' => $quantity
            ]);
        }
    }
}
