<?php

namespace App\Http\Controllers;

use App\Models\Pack;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        $packs = Pack::query()->where('is_active', true)->orderBy('price_per_day')->limit(6)->get();

        return view('home.index', compact('packs'));
    }
}
