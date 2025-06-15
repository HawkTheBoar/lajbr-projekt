@extends('layouts.catalogue')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Hero Section -->
    <div class="bg-gradient-to-r from-purple-600 to-indigo-700 rounded-2xl p-8 mb-12 text-white">
        <div class="max-w-3xl">
            <h1 class="text-4xl font-bold mb-4">Discover Amazing Products</h1>
            <p class="text-xl mb-8">Browse our carefully curated collection of high-quality items</p>
            <a href="#featured" class="bg-white text-purple-700 font-semibold py-3 px-6 rounded-lg hover:bg-gray-100 transition-colors">
                Shop Now
            </a>
        </div>
    </div>

    <!-- Featured Categories -->
    <div class="mb-12">
        <h2 class="text-2xl font-bold mb-6 text-gray-800">Shop by Category</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach($rootCategories as $category)
            <a href="{{ route('catalogue.category', $category) }}" class="category-card">
                <div class="flex items-center">
                    @if($category->image_uri)
                    <img src="{{ asset('storage/' . $category->image_uri) }}" alt="{{ $category->title }}" class="w-16 h-16 object-cover rounded-lg">
                    @endif
                    <div class="ml-4">
                        <h3 class="font-bold text-lg text-gray-800">{{ $category->title }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $category->products()->count() }} products</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>

    <!-- Featured Products -->
    <div id="featured" class="mb-12">
        <div class="flex justify-between items-center mb-6">
            <h2 class="text-2xl font-bold text-gray-800">Featured Products</h2>
            <a href="#" class="text-purple-600 hover:text-purple-800">View All</a>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($featuredProducts as $product)
            <a href="{{ route('catalogue.product', $product) }}" class="catalogue-card">
                <div class="h-48 bg-gray-200 rounded-t-xl overflow-hidden">
                    @if($product->image_uri)
                    <img src="{{ asset('storage/' . $product->image_uri) }}" alt="{{ $product->title }}" class="w-full h-full object-cover">
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
</div>
@endsection
