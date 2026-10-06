<?php

namespace App\Services;

use App\Models\Pack;
use App\Models\Setting;

class EnergyCalculatorService
{
    public function settings(): array
    {
        return [
            'energy_margin' => (float) Setting::getValue('default_energy_margin', 1.20),
            'system_efficiency' => (float) Setting::getValue('default_system_efficiency', 0.85),
            'solar_hours' => (float) Setting::getValue('default_solar_hours', 4.5),
            'inverter_factor' => (float) Setting::getValue('default_inverter_factor', 1.25),
            'lithium_dod' => (float) Setting::getValue('default_lithium_dod', 0.80),
            'lead_dod' => (float) Setting::getValue('default_lead_dod', 0.50),
            'battery_voltage' => (int) Setting::getValue('default_battery_voltage', 48),
        ];
    }

    /**
     * @param  array<int, array<string, mixed>>  $appliances
     * @return array<string, mixed>
     */
    public function calculate(array $appliances, ?string $projectType = null, string $batteryType = 'lithium'): array
    {
        $cfg = $this->settings();
        $dod = $batteryType === 'lead' ? $cfg['lead_dod'] : $cfg['lithium_dod'];
        $voltage = $cfg['battery_voltage'];

        $totalEnergy = 0.0;
        $maxPower = 0.0;
        $largestSurgeExtra = 0.0;
        $items = [];

        foreach ($appliances as $appliance) {
            $power = (float) ($appliance['power_w'] ?? 0);
            $quantity = (int) ($appliance['quantity'] ?? 0);
            $duration = (float) ($appliance['duration_hours'] ?? 0);
            $hasSurge = (bool) ($appliance['has_startup_surge'] ?? false);
            $startupFactor = (float) ($appliance['startup_factor'] ?? 3);

            $energy = $power * $quantity * $duration;
            $simultaneous = $power * $quantity;
            $startupPower = $hasSurge ? $simultaneous * $startupFactor : $simultaneous;
            $surgeExtra = max(0, $startupPower - $simultaneous);

            $totalEnergy += $energy;
            $maxPower += $simultaneous;
            $largestSurgeExtra = max($largestSurgeExtra, $surgeExtra);

            $items[] = [
                'appliance_id' => $appliance['appliance_id'] ?? null,
                'name' => $appliance['name'] ?? 'Appareil',
                'power_w' => (int) $power,
                'quantity' => $quantity,
                'duration_hours' => $duration,
                'usage_period' => $appliance['usage_period'] ?? 'jour',
                'has_startup_surge' => $hasSurge,
                'startup_power_w' => (int) round($startupPower),
                'energy_wh' => round($energy, 2),
            ];
        }

        $peakPower = $maxPower + $largestSurgeExtra;

        $energyWithMargin = $totalEnergy * $cfg['energy_margin'];
        $systemEnergy = $cfg['system_efficiency'] > 0
            ? $energyWithMargin / $cfg['system_efficiency']
            : $energyWithMargin;
        $batteryEnergy = $dod > 0 ? $systemEnergy / $dod : $systemEnergy;
        $batteryAh = $voltage > 0 ? $batteryEnergy / $voltage : 0;
        $inverterContinuous = $maxPower * $cfg['inverter_factor'];
        $solarDenominator = $cfg['solar_hours'] * $cfg['system_efficiency'];
        $solarPower = $solarDenominator > 0 ? $systemEnergy / $solarDenominator : 0;

        $compatiblePacks = $this->recommendPacks($batteryEnergy, $inverterContinuous, $peakPower);

        return [
            'project_type' => $projectType,
            'items' => $items,
            'total_energy_wh' => round($totalEnergy, 2),
            'energy_with_margin_wh' => round($energyWithMargin, 2),
            'system_energy_wh' => round($systemEnergy, 2),
            'max_simultaneous_power_w' => round($maxPower, 2),
            'peak_power_w' => round($peakPower, 2),
            'recommended_battery_wh' => round($batteryEnergy, 2),
            'recommended_battery_ah' => round($batteryAh, 2),
            'battery_voltage' => $voltage,
            'battery_type' => $batteryType,
            'dod' => $dod,
            'recommended_inverter_w' => round($inverterContinuous, 2),
            'recommended_solar_w' => round($solarPower, 2),
            'compatible_packs' => $compatiblePacks,
            'recommended_pack' => $compatiblePacks->first(),
            'settings' => $cfg,
        ];
    }

    public function recommendPacks(float $batteryWh, float $inverterW, float $peakW)
    {
        return Pack::query()
            ->where('is_active', true)
            ->orderBy('energy_capacity_wh')
            ->get()
            ->filter(function (Pack $pack) use ($batteryWh, $inverterW, $peakW) {
                $surgeOk = $pack->surge_power_w === null || $pack->surge_power_w >= $peakW;

                return $pack->energy_capacity_wh >= $batteryWh
                    && $pack->continuous_power_w >= $inverterW
                    && $surgeOk;
            })
            ->values();
    }
}
