<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Appliance;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ApplianceController extends Controller
{
    public function index(): View
    {
        $appliances = Appliance::query()->orderBy('name')->paginate(30);

        return view('admin.appliances.index', compact('appliances'));
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'name' => 'required|string|max:120',
            'default_power_w' => 'required|integer|min:1',
            'default_duration_hours' => 'required|numeric|min:0.1',
            'startup_factor' => 'required|numeric|min:1',
            'category' => 'nullable|string|max:80',
        ]);
        $data['has_startup_surge'] = $request->boolean('has_startup_surge');
        Appliance::query()->create($data);

        return back()->with('success', 'Appareil ajouté.');
    }

    public function destroy(Appliance $appliance): RedirectResponse
    {
        $appliance->delete();

        return back()->with('success', 'Appareil supprimé.');
    }
}
