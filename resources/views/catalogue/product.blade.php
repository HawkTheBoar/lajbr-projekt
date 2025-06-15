@extends('layouts.catalogue')

@section('content')
<div class="max-w-7xl mx-auto">
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        <!-- Product Images -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="h-96 bg-gray-100 rounded-xl overflow-hidden mb-4">
                @if($product->image_uri)
                <img src="{{ asset('storage/' . $product->image_uri) }}"
                     alt="{{ $product->title }}"
                     class="w-full h-full object-contain">
                @endif
            </div>
        </div>

        <!-- Product Details -->
        <div class="bg-white rounded-2xl shadow-md p-6">
            <div class="flex justify-between items-start">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">{{ $product->title }}</h1>
                    @if($product->category)
                    <a href="{{ route('catalogue.category', $product->category) }}"
                       class="text-purple-600 hover:text-purple-800 mt-2 inline-block">
                        {{ $product->category->title }}
                    </a>
                    @endif
                </div>
                <div class="text-3xl font-bold text-purple-600">${{ number_format($product->price, 2) }}</div>
            </div>

            <div class="mt-6">
                <h3 class="text-lg font-semibold text-gray-700 mb-2">Description</h3>
                <p class="text-gray-600">{{ $product->description }}</p>
            </div>

            <div class="mt-8">
                <button onclick="addToCart({{ $product->id }})"
                        class="add-to-cart-btn">
                    <i class="fas fa-cart-plus mr-2"></i> Add to Cart
                </button>
            </div>
        </div>
    </div>

    <!-- Related Products -->
    @if($relatedProducts->count() > 0)
    <div class="mt-12">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Related Products</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($relatedProducts as $product)
            <a href="{{ route('catalogue.product', $product) }}" class="catalogue-card">
                <div class="h-48 bg-gray-200 rounded-t-xl overflow-hidden">
                    @if($product->image_uri)
                    <img src="{{ asset('storage/' . $product->image_uri) }}"
                         alt="{{ $product->title }}"
                         class="w-full h-full object-cover">
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="font-bold text-gray-800 mb-1">{{ $product->title }}</h3>
                    <div class="flex justify-between items-center mt-3">
                        <span class="text-lg font-bold text-purple-600">${{ number_format($product->price, 2) }}</span>
                        <button class="add-to-cart" data-product-id="{{ $product->id }}">
                            <i class="fas fa-cart-plus"></i>
                        </button>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif
</div>
@endsection
