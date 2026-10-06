<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProductController extends Controller
{
    public function index(): View
    {
        $products = Product::query()->with('category')->latest()->paginate(20);

        return view('admin.products.index', compact('products'));
    }

    public function create(): View
    {
        return view('admin.products.form', [
            'product' => new Product(),
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $product = Product::query()->create($this->validated($request));

        $this->storeImage($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Produit créé.');
    }

    public function edit(Product $product): View
    {
        return view('admin.products.form', [
            'product' => $product,
            'categories' => Category::query()->orderBy('name')->get(),
        ]);
    }

    public function update(Request $request, Product $product): RedirectResponse
    {
        $product->update($this->validated($request, $product->id));
        $this->storeImage($request, $product);

        return redirect()->route('admin.products.index')->with('success', 'Produit mis à jour.');
    }

    public function destroy(Product $product): RedirectResponse
    {
        $product->delete();

        return back()->with('success', 'Produit supprimé.');
    }

    private function validated(Request $request, ?int $ignoreId = null): array
    {
        $unique = 'unique:products,reference'.($ignoreId ? ','.$ignoreId : '');

        $data = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'name' => 'required|string|max:160',
            'reference' => 'required|string|max:80|'.$unique,
            'description' => 'nullable|string',
            'power_w' => 'nullable|integer|min:0',
            'voltage_v' => 'nullable|integer|min:0',
            'capacity_wh' => 'nullable|integer|min:0',
            'capacity_ah' => 'nullable|numeric|min:0',
            'surge_power_w' => 'nullable|integer|min:0',
            'daily_price' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'quantity' => 'required|integer|min:0',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'is_active' => 'nullable|boolean',
        ]);

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');

        return $data;
    }

    private function storeImage(Request $request, Product $product): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        $path = $request->file('image')->store('products', 'public');
        $product->update(['image' => $path]);
    }
}
