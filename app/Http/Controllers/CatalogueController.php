<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index()
    {
        $rootCategories = Category::whereNull('parent_id')->with('children')->get();
        $featuredProducts = Product::inRandomOrder()->limit(8)->get();

        return view('catalogue.index', [
            'rootCategories' => $rootCategories,
            'featuredProducts' => $featuredProducts
        ]);
    }

    public function category(Category $category)
    {
        $rootCategories = Category::whereNull('parent_id')->with('children')->get();

        // Get subcategories and products
        $subcategories = $category->children;
        $products = $category->products()->with('category')->paginate(12);

        return view('catalogue.category', [
            'rootCategories' => $rootCategories,
            'currentCategory' => $category,
            'subcategories' => $subcategories,
            'products' => $products
        ]);
    }

    public function product(Product $product)
    {
        $rootCategories = Category::whereNull('parent_id')->with('children')->get();
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('catalogue.product', [
            'rootCategories' => $rootCategories,
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
