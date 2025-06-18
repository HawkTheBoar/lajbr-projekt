<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogueController extends Controller
{
    public function index()
    {
        $featuredProducts = Product::inRandomOrder()->limit(8)->get();

        return view('catalogue.index', [
            'featuredProducts' => $featuredProducts
        ]);
    }

    public function category(Category $category)
    {

        // Get subcategories and products
        $subcategories = $category->children;
        $products = $category->products()->with('category')->paginate(12);

        return view('catalogue.category', [
            'currentCategory' => $category,
            'subcategories' => $subcategories,
            'products' => $products
        ]);
    }

    public function product(Product $product)
    {
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->inRandomOrder()
            ->limit(4)
            ->get();

        return view('catalogue.product', [
            'product' => $product,
            'relatedProducts' => $relatedProducts
        ]);
    }
}
