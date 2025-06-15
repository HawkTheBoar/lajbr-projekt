<?php
namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminCategoryController extends Controller
{
    public function show(Category $category)
    {
        $category->load('products');
        return view('admin.categories.show', compact('category'));
    }
    public function create()
    {
        return view('admin.categories.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('categories', 'public');
            $validated['image_uri'] = $path;
        }

        Category::create($validated);
        return redirect()->route('admin.categories.create')->with('success', 'Category created successfully!');
    }

    public function edit(Category $category)
    {
        return view('admin.categories.edit', [
            'category' => $category,
            'categories' => Category::where('id', '!=', $category->id)->get()
        ]);
    }

    public function update(Request $request, Category $category)
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
            'parent_id' => 'nullable|exists:categories,id'
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($category->image_uri) {
                Storage::disk('public')->delete($category->image_uri);
            }

            $path = $request->file('image')->store('categories', 'public');
            $validated['image_uri'] = $path;
        }

        $category->update($validated);
        return redirect()->back()->with('success', 'Category updated successfully!');
    }

    public function destroy(Category $category)
    {
        // Prevent deleting categories with products
        if ($category->products()->exists()) {
            return redirect()->back()->with('error', 'Cannot delete category with associated products!');
        }

        // Delete associated image
        if ($category->image_uri) {
            Storage::disk('public')->delete($category->image_uri);
        }

        // Update child categories
        Category::where('parent_id', $category->id)->update(['parent_id' => null]);

        $category->delete();
        return redirect()->route('admin.categories.create')->with('success', 'Category deleted successfully!');
    }
}
