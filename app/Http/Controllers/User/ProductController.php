<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $query = Product::where('active', true)->with('category', 'images');

        if ($request->has('category') && $request->category) {
            $query->where('category_id', $request->category);
        }

        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $products = $query->latest()->paginate(12);
        $categories = Category::whereNull('parent_id')->get();

        return view('user.products.index', compact('products', 'categories'));
    }

    public function show(Product $product)
    {
        if (!$product->active) {
            abort(404);
        }

        $product->load('category', 'images');
        $relatedProducts = Product::where('category_id', $product->category_id)
            ->where('id', '!=', $product->id)
            ->where('active', true)
            ->with('images')
            ->limit(4)
            ->get();

        return view('user.products.show', compact('product', 'relatedProducts'));
    }
}
