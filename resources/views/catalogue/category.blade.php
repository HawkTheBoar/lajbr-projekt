@extends('layouts.catalogue')

@section('content')
<div class="max-w-7xl mx-auto">
    <!-- Category Header -->
    <div class="mb-8">
        <div class="flex flex-col md:flex-row items-start md:items-center gap-6">
            @if($currentCategory->image_uri)
            <img src="{{ asset('storage/' . $currentCategory->image_uri) }}"
                 alt="{{ $currentCategory->title }}"
                 class="w-32 h-32 object-cover rounded-xl">
            @endif
            <div>
                <h1 class="text-3xl font-bold text-gray-800">{{ $currentCategory->title }}</h1>
                <p class="text-gray-600 mt-2">{{ $currentCategory->description }}</p>
                <div class="mt-3 text-sm text-gray-500">
                    {{ $products->total() }} products
                </div>
            </div>
        </div>
    </div>

    <!-- Subcategories -->
    @if($subcategories->count() > 0)
    <div class="mb-10">
        <h2 class="text-xl font-bold mb-4 text-gray-700">Subcategories</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($subcategories as $subcategory)
            <a href="{{ route('catalogue.category', $subcategory) }}" class="category-card">
                <div class="flex items-center">
                    @if($subcategory->image_uri)
                    <img src="{{ asset('storage/' . $subcategory->image_uri) }}"
                         alt="{{ $subcategory->title }}"
                         class="w-16 h-16 object-cover rounded-lg">
                    @endif
                    <div class="ml-4">
                        <h3 class="font-bold text-gray-800">{{ $subcategory->title }}</h3>
                        <p class="text-gray-600 text-sm mt-1">{{ $subcategory->products()->count() }} products</p>
                    </div>
                </div>
            </a>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Products Section -->
    <div>
        <h2 class="text-xl font-bold mb-4 text-gray-700">Products</h2>

        @if($products->count() > 0)
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($products as $product)
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
                    <div class="text-sm text-gray-600 line-clamp-2 mb-2">
                        {{ $product->description }}
                    </div>
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

        <!-- Pagination -->
        <div class="mt-8">
            {{ $products->links() }}
        </div>
        @else
        <div class="bg-white rounded-xl shadow p-8 text-center">
            <i class="fas fa-box-open text-5xl text-gray-300 mb-4"></i>
            <h3 class="text-xl font-bold text-gray-700 mb-2">No products found</h3>
            <p class="text-gray-600">There are no products available in this category.</p>
        </div>
        @endif
    </div>
</div>
@endsection
