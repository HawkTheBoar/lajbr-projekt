@extends('layouts.admin')

@section('content')
<div class="max-w-7xl mx-auto">
    <h1 class="text-2xl font-bold mb-6">Admin Dashboard</h1>

    <!-- Products Section -->
    <div class="bg-white rounded-lg shadow overflow-hidden mb-8">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold">Products</h2>
                <div class="mt-4 md:mt-0">
                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="flex">
                            <input type="text" name="product_search" placeholder="Search products..."
                                   value="{{ request('product_search') }}"
                                   class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.products.create') }}" class="ml-3 btn-primary">
                                <i class="fas fa-plus mr-1"></i> New Product
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->image_uri)
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $product->image_uri) }}" alt="{{ $product->title }}">
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <a href="{{ route('admin.products.show', $product) }}" class="text-sm font-medium text-gray-900">
                                            {{ $product->title }}
                                        </a>
                                        <p class="text-sm text-gray-500 line-clamp-1">{{ $product->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($product->category)
                                    <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">
                                        {{ $product->category->title }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                        No category
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this product?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $products->appends(request()->except('products_page'))->links() }}
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                No products found
            </div>
        @endif
    </div>

    <!-- Categories Section -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <h2 class="text-xl font-semibold">Categories</h2>
                <div class="mt-4 md:mt-0">
                    <form method="GET" action="{{ route('admin.dashboard') }}">
                        <div class="flex">
                            <input type="text" name="category_search" placeholder="Search categories..."
                                   value="{{ request('category_search') }}"
                                   class="px-4 py-2 border border-gray-300 rounded-l-md focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:border-indigo-500">
                            <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded-r-md hover:bg-indigo-700">
                                <i class="fas fa-search"></i>
                            </button>
                            <a href="{{ route('admin.categories.create') }}" class="ml-3 btn-primary">
                                <i class="fas fa-plus mr-1"></i> New Category
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        @if($categories->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Parent</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Products</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($categories as $category)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($category->image_uri)
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $category->image_uri) }}" alt="{{ $category->title }}">
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <a href="{{ route('admin.categories.show', $category) }}" class="text-sm font-medium text-gray-900">
                                            {{ $category->title }}
                                        </a>
                                        <p class="text-sm text-gray-500 line-clamp-1">{{ $category->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                @if($category->parent)
                                    <span class="bg-indigo-100 text-indigo-800 px-2 py-1 rounded-full text-xs">
                                        {{ $category->parent->title }}
                                    </span>
                                @else
                                    <span class="bg-gray-100 text-gray-800 px-2 py-1 rounded-full text-xs">
                                        No parent
                                    </span>
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                <span class="bg-green-100 text-green-800 px-2 py-1 rounded-full text-xs">
                                    {{ $category->products_count }} products
                                </span>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $category->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <a href="{{ route('admin.categories.edit', $category) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.categories.show', $category) }}" class="text-blue-600 hover:text-blue-900 mr-3">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Delete this category?')">
                                        <i class="fas fa-trash"></i>
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            <div class="px-6 py-4 border-t border-gray-200">
                {{ $categories->appends(request()->except('categories_page'))->links() }}
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                No categories found
            </div>
        @endif
    </div>
</div>
@endsection
