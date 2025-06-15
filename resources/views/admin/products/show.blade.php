@extends('layouts.admin')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold">{{ $product->title }}</h1>
        <div class="space-x-3">
            <a href="{{ route('admin.products.edit', $product) }}" class="btn-primary">
                <i class="fas fa-edit mr-1"></i> Edit
            </a>
            <form action="{{ route('admin.products.destroy', $product) }}" method="POST" class="inline-block">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn-danger" onclick="return confirm('Are you sure?')">
                    <i class="fas fa-trash mr-1"></i> Delete
                </button>
            </form>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="md:flex">
            @if($product->image_uri)
            <div class="md:w-1/3 bg-gray-100 flex items-center justify-center p-6">
                <img src="{{ asset('storage/' . $product->image_uri) }}" alt="{{ $product->title }}" class="max-h-64 object-contain">
            </div>
            @endif
            <div class="p-6 md:w-{{ $product->image_uri ? '2/3' : 'full' }}">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <div class="col-span-2">
                        <h2 class="text-lg font-semibold text-gray-700">Description</h2>
                        <p class="mt-1 text-gray-600">{{ $product->description ?? 'No description' }}</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Category</h2>
                        <p class="mt-1 text-gray-600">
                            @if($product->category)
                                <a href="{{ route('admin.categories.show', $product->category) }}" class="text-indigo-600 hover:underline">
                                    {{ $product->category->title }}
                                </a>
                            @else
                                No category
                            @endif
                        </p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Price</h2>
                        <p class="mt-1 text-gray-600">${{ number_format($product->price, 2) }}</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Created At</h2>
                        <p class="mt-1 text-gray-600">{{ $product->created_at->format('M d, Y H:i') }}</p>
                    </div>

                    <div>
                        <h2 class="text-lg font-semibold text-gray-700">Updated At</h2>
                        <p class="mt-1 text-gray-600">{{ $product->updated_at->format('M d, Y H:i') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('admin.products.create') }}" class="btn-secondary">
            <i class="fas fa-arrow-left mr-2"></i> Back to Products
        </a>
    </div>
</div>
@endsection
