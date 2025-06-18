<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\CartService;
class CheckoutController extends Controller
{
    protected $cartService;

    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
    public function index(){

        $this->cartService->emptyCart();
        return view('thankyou');
    }
}
