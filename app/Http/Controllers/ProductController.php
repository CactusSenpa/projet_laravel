<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(Request $request): View
    {
        $query = Product::query()->with('category')->where('is_active', true);

        if ($request->filled('category')) {
            $query->where('category_id', $request->integer('category'));
        }

        if ($request->filled('category_slug')) {
            $query->whereHas('category', fn ($q) => $q->where('slug', $request->string('category_slug')));
        }

        if ($request->filled('power_min')) {
            $query->where('power_w', '>=', $request->integer('power_min'));
        }

        if ($request->filled('power_max')) {
            $query->where('power_w', '<=', $request->integer('power_max'));
        }

        if ($request->filled('price_max')) {
            $query->where('daily_price', '<=', $request->input('price_max'));
        }

        if ($request->boolean('available')) {
            $query->where('quantity', '>', 0);
        }

        $products = $query->orderBy('name')->paginate(12)->withQueryString();
        $categories = Category::query()->orderBy('name')->get();

        return view('products.index', compact('products', 'categories'));
    }

    public function show(Product $product): View
    {
        abort_unless($product->is_active, 404);
        $product->load('category');

        return view('products.show', compact('product'));
    }
}
