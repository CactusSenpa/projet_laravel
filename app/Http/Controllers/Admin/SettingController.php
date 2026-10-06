<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SettingController extends Controller
{
    public function index(): View
    {
        $settings = Setting::query()->orderBy('key')->get()->pluck('value', 'key');

        return view('admin.settings.index', compact('settings'));
    }

    public function update(Request $request): RedirectResponse
    {
        $data = $request->validate([
            'company_name' => 'required|string|max:120',
            'whatsapp_number' => 'required|string|max:30',
            'default_system_efficiency' => 'required|numeric|min:0.1|max:1',
            'default_energy_margin' => 'required|numeric|min:1',
            'default_solar_hours' => 'required|numeric|min:1',
            'default_inverter_factor' => 'required|numeric|min:1',
            'default_lithium_dod' => 'required|numeric|min:0.1|max:1',
            'default_lead_dod' => 'required|numeric|min:0.1|max:1',
            'default_battery_voltage' => 'required|integer|min:12',
            'delivery_fee' => 'required|numeric|min:0',
        ]);

        foreach ($data as $key => $value) {
            Setting::putValue($key, $value);
        }

        return back()->with('success', 'Paramètres enregistrés.');
    }
}
