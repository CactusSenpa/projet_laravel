<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Availability;
use Illuminate\View\View;

class AvailabilityController extends Controller
{
    public function index(): View
    {
        $availabilities = Availability::query()
            ->with(['pack', 'product'])
            ->orderBy('date')
            ->paginate(30);

        return view('admin.availability.index', compact('availabilities'));
    }
}
