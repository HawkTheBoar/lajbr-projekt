<?php

namespace App\Http\Controllers;

use App\Models\TestModel;
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
        $cart = $this->cartService->getCart();
        $total = $this->cartService->getTotal();

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

    public function removeProduct(int $productId): RedirectResponse
    {
        $this->cartService->removeItem($productId);
        return redirect()->route('cart.index')->with('success', 'Product removed from cart!');
    }

    public function emptyCart(): RedirectResponse
    {
        $this->cartService->emptyCart();
        return redirect()->route('cart.index')->with('success', 'Your cart has been emptied!');
    }
}
