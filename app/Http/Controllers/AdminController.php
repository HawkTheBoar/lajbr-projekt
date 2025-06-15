<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    // Admin dashboard
    public function index(): View
    {
        return view('admin.dashboard');
    }

    // List all categories
    public function categories(): View
    {
        $categories = Category::withCount('products')
            ->orderBy('created_at', 'desc')
            ->get();
        return view('admin.categories.index', compact('categories'));
    }

    // Show products in a specific category
    public function category($id): View
    {
        $category = Category::with(['products' => function($query) {
            $query->with('currentPrice')->orderBy('created_at', 'desc');
        }])->findOrFail($id);

        return view('admin.categories.show', [
            'category' => $category,
            'products' => $category->products
        ]);
    }

    // Edit product view
    public function product($id): View
    {
        $product = Product::with(['category', 'prices' => function($query) {
            $query->orderBy('date_applied', 'desc');
        }])->findOrFail($id);

        $categories = Category::whereNull('parent_id')
            ->with('children')
            ->get();

        return view('admin.products.edit', [
            'product' => $product,
            'categories' => $categories,
            'currentPrice' => $product->currentPrice
        ]);
    }
}
