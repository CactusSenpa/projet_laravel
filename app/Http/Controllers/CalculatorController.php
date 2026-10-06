<?php

namespace App\Http\Controllers;

use App\Http\Requests\CalculateEnergyRequest;
use App\Models\Appliance;
use App\Models\Quote;
use App\Services\EnergyCalculatorService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CalculatorController extends Controller
{
    public function __construct(private EnergyCalculatorService $calculator)
    {
    }

    public function index(): View
    {
        $appliances = Appliance::query()->orderBy('name')->get();

        return view('calculator.index', compact('appliances'));
    }

    public function calculate(CalculateEnergyRequest $request): RedirectResponse
    {
        $items = collect($request->validated()['items'])->map(function (array $item) {
            $item['has_startup_surge'] = (bool) ($item['has_startup_surge'] ?? false);

            return $item;
        })->all();

        $result = $this->calculator->calculate(
            $items,
            $request->validated()['project_type'],
            $request->input('battery_type', 'lithium')
        );

        $quote = Quote::query()->create([
            'project_type' => $result['project_type'],
            'total_energy_wh' => $result['total_energy_wh'],
            'energy_with_margin_wh' => $result['energy_with_margin_wh'],
            'max_simultaneous_power_w' => $result['max_simultaneous_power_w'],
            'peak_power_w' => $result['peak_power_w'],
            'recommended_battery_wh' => $result['recommended_battery_wh'],
            'recommended_battery_ah' => $result['recommended_battery_ah'],
            'battery_voltage' => $result['battery_voltage'],
            'recommended_inverter_w' => $result['recommended_inverter_w'],
            'recommended_solar_w' => $result['recommended_solar_w'],
            'recommended_pack_id' => $result['recommended_pack']?->id,
        ]);

        foreach ($result['items'] as $item) {
            $quote->items()->create($item);
        }

        return redirect()->route('calculator.result', $quote);
    }

    public function result(Quote $quote): View
    {
        $quote->load(['items', 'recommendedPack.products']);
        $compatible = $this->calculator->recommendPacks(
            (float) $quote->recommended_battery_wh,
            (float) $quote->recommended_inverter_w,
            (float) $quote->peak_power_w
        );

        return view('calculator.result', compact('quote', 'compatible'));
    }
}
