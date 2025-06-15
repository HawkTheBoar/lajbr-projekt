<?php
namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AdminProductController extends Controller
{
    public function show(Product $product): View
    {
        return view('admin.products.show', compact('product'));
    }
    public function create(): View
    {
        return view('admin.products.create', [
            'categories' => Category::all()
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0'
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('products', 'public');
            $validated['image_uri'] = $path;
        }

        Product::create($validated);
        return redirect()->route('admin.products.create')->with('success', 'Product created successfully!');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.edit', [
            'product' => $product,
            'categories' => Category::all()
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $validated = $request->validate([
            'title' => 'required|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'description' => 'nullable',
            'category_id' => 'nullable|exists:categories,id',
            'price' => 'required|numeric|min:0'
        ]);

        // Handle file upload
        if ($request->hasFile('image')) {
            // Delete old image if exists
            if ($product->image_uri) {
                Storage::disk('public')->delete($product->image_uri);
            }

            $path = $request->file('image')->store('products', 'public');
            $validated['image_uri'] = $path;
        }

        $product->update($validated);
        return redirect()->back()->with('success', 'Product updated successfully!');
    }

    public function destroy(Product $product): RedirectResponse
    {
        // Delete associated image
        if ($product->image_uri) {
            Storage::disk('public')->delete($product->image_uri);
        }

        $product->delete();
        return redirect()->route('admin.products.create')->with('success', 'Product deleted successfully!');
    }
}
