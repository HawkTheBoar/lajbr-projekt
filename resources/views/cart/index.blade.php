@extends('layouts.catalogue')

@section('content')
<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold mb-6">Your Shopping Cart</h1>

    @if(count($cart) > 0)
        <div class="bg-white shadow-md rounded-lg overflow-hidden">
            <table class="min-w-full">
                <thead class="bg-gray-100">
                    <tr>
                        <th class="py-3 px-4 text-left">Product</th>
                        <th class="py-3 px-4 text-left">Price</th>
                        <th class="py-3 px-4 text-left">Quantity</th>
                        <th class="py-3 px-4 text-left">Total</th>
                        <th class="py-3 px-4 text-left">Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cart as $item)
                    @php $product = $item['product'] @endphp
                    <tr class="border-b">
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                @if($product->image_uri)
                                <img src="{{ asset('storage/' . $product->image_uri) }}"
                                     alt="{{ $product->title }}"
                                     class="w-16 h-16 object-cover rounded mr-4">
                                @else
                                <div class="bg-gray-200 border-2 border-dashed rounded-xl w-16 h-16 mr-4 flex items-center justify-center">
                                    <i class="fas fa-image text-gray-400"></i>
                                </div>
                                @endif
                                <div>
                                    <div class="font-medium">{{ $product->title }}</div>
                                    @if($product->category)
                                    <div class="text-sm text-gray-600">{{ $product->category->title }}</div>
                                    @endif
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">${{ number_format($product->price, 2) }}</td>
                        <td class="py-4 px-4">
                            <div class="flex items-center">
                                <span class="mr-4">{{ $item['quantity'] }}</span>
                                <div class="flex space-x-1">
                                    <form method="POST" action="{{ route('cart.addproduct') }}">
                                        @csrf
                                        <input type="hidden" name="productId" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="text-green-600 hover:text-green-800 p-1">
                                            <i class="fas fa-plus-circle"></i>
                                        </button>
                                    </form>
                                    <form method="POST" action="{{ route('cart.removeproduct') }}">
                                        @csrf
                                        <input type="hidden" name="productId" value="{{ $product->id }}">
                                        <input type="hidden" name="quantity" value="1">
                                        <button type="submit" class="text-purple-600 hover:text-purple-800 p-1">
                                            <i class="fas fa-minus-circle"></i>
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </td>
                        <td class="py-4 px-4">${{ number_format($item['total'], 2) }}</td>
                        <td class="py-4 px-4">
                            <form method="POST" action="{{ route('cart.removeproduct') }}">
                                @csrf
                                <input type="hidden" name="productId" value="{{ $product->id }}">
                                <input type="hidden" name="quantity" value="{{ $item['quantity'] }}">
                                <button type="submit" class="text-red-600 hover:text-red-800" title="Remove all">
                                    <i class="fas fa-trash"></i>
                                </button>
                            </form>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="mt-6 flex flex-col sm:flex-row justify-between items-center space-y-4 sm:space-y-0">
            <form method="POST" action="{{ route('cart.empty') }}">
                @csrf
                <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white px-4 py-2 rounded-lg">
                    <i class="fas fa-trash mr-2"></i>Empty Cart
                </button>
            </form>

            <div class="bg-white shadow-md rounded-lg p-6 w-full sm:w-1/3">
                <div class="flex justify-between items-center mb-4">
                    <span class="font-bold text-lg">Subtotal:</span>
                    <span class="font-bold text-lg">${{ number_format($total, 2) }}</span>
                </div>
                <div class="flex justify-between items-center mb-4 text-gray-600">
                    <span>Shipping:</span>
                    <span>Calculated at checkout</span>
                </div>
                <div class="border-t border-gray-200 my-4"></div>
                <div class="flex justify-between items-center mb-6">
                    <span class="font-bold text-xl">Total:</span>
                    <span class="font-bold text-xl">${{ number_format($total, 2) }}</span>
                </div>
                <a href="{{ route('cart.checkout.index') }}" class="add-to-cart-btn w-full text-center">
                    Proceed to Checkout
                </a>
            </div>
        </div>
    @else
        <div class="text-center py-12">
            <i class="fas fa-shopping-cart text-5xl text-gray-300 mb-4"></i>
            <h2 class="text-2xl font-semibold">Your cart is empty</h2>
            <p class="mt-2 text-gray-600">Looks like you haven't added any items to your cart yet.</p>
            <a href="{{ route('catalogue.index') }}" class="mt-4 inline-block bg-purple-600 text-white px-6 py-3 rounded-lg hover:bg-purple-700 transition-colors">
                <i class="fas fa-arrow-left mr-2"></i>Browse Products
            </a>
        </div>
    @endif
</div>
@endsection
