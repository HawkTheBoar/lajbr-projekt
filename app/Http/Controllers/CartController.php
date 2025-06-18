<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Services\CartService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class CartController extends Controller
{

    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }

    public function index(): View
    {
        $cartItems = $this->cartService->getStoredProducts();
        $productIds = array_column($cartItems, 'productId');

        // Fetch products with eager loading of prices
        $products = Product::whereIn('id', $productIds)
            ->get()
            ->keyBy('id');

        $total = 0;
        $cart = [];

        foreach ($cartItems as $item) {
            $productId = $item['productId'];

            if (isset($products[$productId])) {
                $product = $products[$productId];
                $price = $product->price; // Assuming price is a direct attribute

                $itemTotal = $price * $item['quantity'];
                $total += $itemTotal;

                $cart[] = [
                    'product' => $product,
                    'quantity' => $item['quantity'],
                    'total' => $itemTotal
                ];
            }
        }

        return view('cart.index', compact('cart', 'total'));
    }

    public function addProduct(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);

        $this->cartService->addItem(
            $validated['productId'],
            $validated['quantity'] ?? 1
        );

        return redirect()->back()->with('success', 'Product added to cart!');
    }

    public function removeProduct(Request $request): RedirectResponse{
        $validated = $request->validate([
            'productId' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1',
        ]);
        $this->cartService->removeItem(
            $validated['productId'],
            $validated['quantity'] ?? 1
        );
        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function emptyCart(): RedirectResponse
    {
        $this->cartService->emptyCart();
        return redirect()->route('cart.index')->with('success', 'Your cart has been emptied!');
    }
}
