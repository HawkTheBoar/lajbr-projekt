<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index(Request $request): View
    {
        // Products query with search/filter
        $products = Product::query()
            ->when($request->filled('product_search'), function ($query) use ($request) {
                $search = $request->input('product_search');
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->with('category')
            ->latest()
            ->paginate(10, ['*'], 'products_page')
            ->withQueryString();

        // Categories query with search/filter
        $categories = Category::query()
            ->when($request->filled('category_search'), function ($query) use ($request) {
                $search = $request->input('category_search');
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('description', 'like', "%{$search}%");
            })
            ->withCount('products')
            ->with('parent')
            ->latest()
            ->paginate(10, ['*'], 'categories_page')
            ->withQueryString();

        return view('admin.dashboard', compact('products', 'categories'));
    }
}
