<div class="grid grid-cols-1 md:grid-cols-2 gap-6">
    <!-- Title -->
    <div class="col-span-2">
        <label for="title" class="block text-sm font-medium text-gray-700">Title *</label>
        <input type="text" name="title" id="title" value="{{ old('title', $category->title ?? '') }}"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500" required>
        @error('title') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Parent Category -->
    <div>
        <label for="parent_id" class="block text-sm font-medium text-gray-700">Parent Category</label>
        <select name="parent_id" id="parent_id" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            <option value="">No Parent</option>
            @foreach($categories as $cat)
                @if(($category->id ?? null) !== $cat->id)
                    <option value="{{ $cat->id }}"
                        {{ ($category->parent_id ?? old('parent_id')) == $cat->id ? 'selected' : '' }}>
                        {{ $cat->title }}
                    </option>
                @endif
            @endforeach
        </select>
        @error('parent_id') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>

    <!-- Image Upload -->
    <div>
        <label for="image" class="block text-sm font-medium text-gray-700">Category Image</label>
        <input type="file" name="image" id="image" accept="image/*"
               class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
        @error('image') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror

        <!-- Show current image if exists -->
        @if(isset($category) && $category->image_uri)
            <div class="mt-4">
                <p class="text-sm text-gray-500">Current Image:</p>
                <img src="{{ asset('storage/' . $category->image_uri) }}" alt="Category Image" class="mt-2 h-32 object-contain">
            </div>
        @endif
    </div>

    <!-- Description -->
    <div class="col-span-2">
        <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
        <textarea name="description" id="description" rows="4"
                  class="mt-1 block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">{{ old('description', $category->description ?? '') }}</textarea>
        @error('description') <p class="mt-1 text-sm text-red-600">{{ $message }}</p> @enderror
    </div>
</div>
