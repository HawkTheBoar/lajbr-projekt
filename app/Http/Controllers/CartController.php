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
        return view('cart.index', compact('cart'));
    }
    public function addproduct(Request $request): RedirectResponse // Modify parameter and return type
    {
        $validated = $request->validate([
            'productId' => 'required',
            'quantity' => 'required',
        ]);
        // Retrieve GET parameters
        $productId = $validated['productId'];
        $quantity = $validated['quantity']; // Default to 1 if not provided

        // Add product to cart
        $this->cartService->addItem($productId, $quantity);

        // Redirect back to cart page with success message
        return redirect()->back()->with('success', 'Product added to cart!');
    }

}
