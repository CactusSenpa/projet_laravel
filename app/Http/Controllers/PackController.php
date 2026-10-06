<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\View\View;

class PackController extends Controller
{
    public function index(): View
    {
        $packs = Pack::query()->where('is_active', true)->with('products')->orderBy('price_per_day')->get();

        return view('packs.index', compact('packs'));
    }

    public function show(Pack $pack): View
    {
        abort_unless($pack->is_active, 404);
        $pack->load('products.category');

        return view('packs.show', compact('pack'));
    }
}
