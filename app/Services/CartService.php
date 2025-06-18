<?php
namespace App\Services;
use Illuminate\Support\Facades\Session;

class CartService
{
    /**
     * Get all stored products in cart
     * @return array<array{productId: int, quantity: int}>
     */
    public function getStoredProducts(): array
    {
        // Return cart items or empty array if none exists
        return Session::get('cart', []);
    }

    /**
     * Add item to cart or update existing item quantity
     * @param int $productId
     * @param int $quantity
     */
    public function addItem(int $productId, int $quantity = 1): void
    {
        $cart = $this->getStoredProducts();
        $found = false;

        // Update existing product quantity
        foreach ($cart as &$item) {
            if ($item['productId'] === $productId) {
                $item['quantity'] += $quantity;
                $found = true;
                break;
            }
        }

        // Add new item if product doesn't exist in cart
        if (!$found) {
            $cart[] = [
                'productId' => $productId,
                'quantity' => $quantity
            ];
        }

        Session::put('cart', $cart);
    }

    /**
     * Remove item from cart or reduce quantity
     * @param int $productId
     * @param int $quantity
     */
    public function removeItem(int $productId, int $quantity = 1): void
    {
        $cart = $this->getStoredProducts();

        foreach ($cart as $index => &$item) {
            if ($item['productId'] === $productId) {
                // Reduce quantity
                $item['quantity'] -= $quantity;

                // Remove item if quantity drops to zero or below
                if ($item['quantity'] <= 0) {
                    unset($cart[$index]);
                }
                break;
            }
        }

        // Reindex array after potential removal
        Session::put('cart', array_values($cart));
    }
    public function emptyCart(): void{
        Session::forget('cart');
    }
    public function totalItems(): int
    {
        $items = $this->getStoredProducts();
        $total = 0;

        foreach ($items as $item) {
            $total += $item['quantity'];
        }

        return $total;
    }
}
