@extends('layouts.admin')

@section('content')
<div class="max-w-6xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $category->title }}</h1>
        <div class="space-x-3">
            <a href="{{ route('admin.categories.edit', $category) }}" class="btn-primary">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('admin.categories.destroy', $category) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden mb-6">
        <div class="md:flex">
            @if($category->image_uri)
            <div class="md:w-1/3 bg-gray-100 flex items-center justify-center p-6">
                <img src="{{ asset('storage/' . $category->image_uri) }}" alt="{{ $category->title }}" class="max-h-64 object-contain">
            </div>
            @endif
            <div class="p-6 md:w-{{ $category->image_uri ? '2/3' : 'full' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <h2 class="text-lg font-semibold text-gray-700">Description</h2>
                        <p class="mt-1 text-gray-600">{{ $category->description ?? 'No description' }}</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Parent Category</h2>
                        <p class="mt-1 text-gray-600">
                            @if($category->parent)
                                <a href="{{ route('admin.categories.show', $category->parent) }}" class="text-indigo-600 hover:underline">
                                    {{ $category->parent->title }}
                                </a>
                            @else
                                No parent category
                            @endif
                        </p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Subcategories</h2>
                        <p class="mt-1 text-gray-600">
                            @if($category->children->count() > 0)
                                {{ $category->children->count() }} subcategories
                            @else
                                No subcategories
                            @endif
                        </p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Created At</h2>
                        <p class="mt-1 text-gray-600">{{ $category->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Updated At</h2>
                        <p class="mt-1 text-gray-600">{{ $category->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Products Table -->
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b border-gray-200">
            <h2 class="text-xl font-semibold">Products in this Category</h2>
        </div>

        @if($category->products->count() > 0)
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Product</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Created</th>
                            <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach($category->products as $product)
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    @if($product->image_uri)
                                    <div class="flex-shrink-0 h-10 w-10">
                                        <img class="h-10 w-10 rounded-md object-cover" src="{{ asset('storage/' . $product->image_uri) }}" alt="{{ $product->title }}">
                                    </div>
                                    @endif
                                    <div class="ml-4">
                                        <a href="{{ route('admin.products.show', $product) }}" class="text-sm font-medium text-indigo-600 hover:underline">
                                            {{ $product->title }}
                                        </a>
                                        <p class="text-sm text-gray-500 line-clamp-1">{{ $product->description }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                ${{ number_format($product->price, 2) }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                                {{ $product->created_at->format('M d, Y') }}
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                <a href="{{ route('admin.products.edit', $product) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="{{ route('admin.products.show', $product) }}" class="text-blue-600 hover:text-blue-900">
                                    <i class="fas fa-eye"></i>
                                </a>
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-6 text-center text-gray-500">
                No products found in this category
            </div>
        @endif
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.categories.create') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Categories
        </a>
    </div>
</div>
@endsection
