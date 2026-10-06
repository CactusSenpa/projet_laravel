<?php

namespace App\Http\Controllers;

use Illuminate\View\View;

class PageController extends Controller
{
    public function conditions(): View
    {
        return view('conditions.index');
    }
}
