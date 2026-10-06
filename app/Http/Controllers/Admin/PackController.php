<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Pack;
use App\Models\Product;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PackController extends Controller
{
    public function index(): View
    {
        $packs = Pack::query()->withCount('products')->latest()->paginate(20);

        return view('admin.packs.index', compact('packs'));
    }

    public function create(): View
    {
        return view('admin.packs.form', [
            'pack' => new Pack(),
            'products' => Product::query()->orderBy('name')->get(),
            'selected' => [],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $pack = Pack::query()->create($this->validated($request));
        $this->syncProducts($request, $pack);
        $this->storeImage($request, $pack);

        return redirect()->route('admin.packs.index')->with('success', 'Pack créé.');
    }

    public function edit(Pack $pack): View
    {
        $pack->load('products');

        return view('admin.packs.form', [
            'pack' => $pack,
            'products' => Product::query()->orderBy('name')->get(),
            'selected' => $pack->products->pluck('pivot.quantity', 'id')->all(),
        ]);
    }

    public function update(Request $request, Pack $pack): RedirectResponse
    {
        $pack->update($this->validated($request));
        $this->syncProducts($request, $pack);
        $this->storeImage($request, $pack);

        return redirect()->route('admin.packs.index')->with('success', 'Pack mis à jour.');
    }

    public function destroy(Pack $pack): RedirectResponse
    {
        $pack->delete();

        return back()->with('success', 'Pack supprimé.');
    }

    private function validated(Request $request): array
    {
        $data = $request->validate([
            'name' => 'required|string|max:160',
            'description' => 'nullable|string',
            'price_per_day' => 'required|numeric|min:0',
            'deposit' => 'required|numeric|min:0',
            'energy_capacity_wh' => 'required|integer|min:1',
            'continuous_power_w' => 'required|integer|min:1',
            'surge_power_w' => 'nullable|integer|min:0',
            'recommended_uses' => 'nullable|string',
            'image' => 'nullable|image|max:2048|mimes:jpg,jpeg,png,webp',
            'is_active' => 'nullable|boolean',
        ]);

        unset($data['image']);
        $data['is_active'] = $request->boolean('is_active');
        $data['recommended_uses'] = array_values(array_filter(array_map('trim', explode(',', (string) ($data['recommended_uses'] ?? '')))));

        return $data;
    }

    private function syncProducts(Request $request, Pack $pack): void
    {
        $sync = [];
        foreach ($request->input('product_qty', []) as $productId => $qty) {
            if ((int) $qty > 0) {
                $sync[(int) $productId] = ['quantity' => (int) $qty];
            }
        }
        $pack->products()->sync($sync);
    }

    private function storeImage(Request $request, Pack $pack): void
    {
        if (! $request->hasFile('image')) {
            return;
        }

        $path = $request->file('image')->store('packs', 'public');
        $pack->update(['image' => $path]);
    }
}
