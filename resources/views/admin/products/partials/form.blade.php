<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Title -->
    <div class="col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $product->title ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Category -->
    <div>
        <label for="category_id" class="block text-sm font-medium text-gray-700">Category</label>
        <select name="category_id" id="category_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">No Category</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ ($product->category_id ?? old('category_id')) == $category->id ? 'selected' : '' }}>
                    {{ $category->title }}
                </option>
            @endforeach
        </select>
        @error('category_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Price -->
    <div>
        <label for="price" class="block text-sm font-medium text-gray-700">Price *</label>
        <input type="number" step="0.01" name="price" id="price" value="{{ old('price', $product->price ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
        @error('price') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Image Upload -->
    <div class="col-span-2">
        <label for="image" class="block text-sm font-medium text-gray-700">Product Image</label>
        <input type="file" name="image" id="image" accept="image/*"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

        <!-- Show current image if exists -->
        @if(isset($product) && $product->image_uri)
            <div class="mt-4">
                <p class="text-sm text-gray-500">Current Image:</p>
                <img src="{{ asset('storage/' . $product->image_uri) }}" alt="Product Image" class="mt-2 h-32 object-contain">
            </div>
        @endif
    </div>

    <!-- Description -->
    <div class="col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $product->description ?? '') }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
