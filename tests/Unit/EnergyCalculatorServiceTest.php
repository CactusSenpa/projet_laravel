<?php

namespace Tests\Unit;

use App\Models\Pack;
use App\Models\Setting;
use App\Services\EnergyCalculatorService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class EnergyCalculatorServiceTest extends TestCase
{
    use RefreshDatabase;

    protected function setUp(): void
    {
        parent::setUp();

        Setting::putValue('default_energy_margin', '1.20');
        Setting::putValue('default_system_efficiency', '0.85');
        Setting::putValue('default_solar_hours', '4.5');
        Setting::putValue('default_inverter_factor', '1.25');
        Setting::putValue('default_lithium_dod', '0.80');
        Setting::putValue('default_lead_dod', '0.50');
        Setting::putValue('default_battery_voltage', '48');
    }

    public function test_night_event_energy_margin_and_recommendations(): void
    {
        $service = new EnergyCalculatorService();
        $result = $service->calculate([
            ['name' => 'LED', 'power_w' => 20, 'quantity' => 10, 'duration_hours' => 5],
            ['name' => 'Enceinte', 'power_w' => 100, 'quantity' => 2, 'duration_hours' => 4],
            ['name' => 'TV', 'power_w' => 120, 'quantity' => 1, 'duration_hours' => 4],
            ['name' => 'Réfrigérateur', 'power_w' => 150, 'quantity' => 1, 'duration_hours' => 6, 'has_startup_surge' => true, 'startup_factor' => 3],
        ], 'evenement');

        $this->assertEquals(3180, $result['total_energy_wh']);
        $this->assertEquals(3816, $result['energy_with_margin_wh']);
        $this->assertEquals(670, $result['max_simultaneous_power_w']);
        $this->assertEquals(970, $result['peak_power_w']);
        $this->assertEqualsWithDelta(4489.41, $result['system_energy_wh'], 0.05);
        $this->assertEqualsWithDelta(5611.76, $result['recommended_battery_wh'], 0.05);
        $this->assertEqualsWithDelta(116.91, $result['recommended_battery_ah'], 0.05);
        $this->assertEquals(837.5, $result['recommended_inverter_w']);
        $this->assertEqualsWithDelta(1173.70, $result['recommended_solar_w'], 0.2);
    }

    public function test_site_tools_use_startup_surge_for_peak_power(): void
    {
        $service = new EnergyCalculatorService();
        $result = $service->calculate([
            ['name' => 'Perceuse', 'power_w' => 800, 'quantity' => 2, 'duration_hours' => 2, 'has_startup_surge' => true, 'startup_factor' => 3],
            ['name' => 'Meuleuse', 'power_w' => 1000, 'quantity' => 1, 'duration_hours' => 1, 'has_startup_surge' => true, 'startup_factor' => 3],
            ['name' => 'LED', 'power_w' => 30, 'quantity' => 4, 'duration_hours' => 8],
            ['name' => 'Ordinateur', 'power_w' => 100, 'quantity' => 1, 'duration_hours' => 8],
        ], 'chantier');

        $this->assertEquals(5960, $result['total_energy_wh']);
        $this->assertEquals(2820, $result['max_simultaneous_power_w']);
        $this->assertEquals(6020, $result['peak_power_w']);
        $this->assertEquals(3525, $result['recommended_inverter_w']);
    }

    public function test_pack_recommendation_filters_undersized_packs(): void
    {
        Pack::query()->create([
            'name' => 'Petit',
            'price_per_day' => 50,
            'deposit' => 100,
            'energy_capacity_wh' => 1000,
            'continuous_power_w' => 500,
            'surge_power_w' => 800,
            'is_active' => true,
        ]);
        $large = Pack::query()->create([
            'name' => 'Grand',
            'price_per_day' => 200,
            'deposit' => 100,
            'energy_capacity_wh' => 20000,
            'continuous_power_w' => 6000,
            'surge_power_w' => 12000,
            'is_active' => true,
        ]);

        $packs = (new EnergyCalculatorService())->recommendPacks(8000, 3000, 5000);

        $this->assertCount(1, $packs);
        $this->assertTrue($packs->first()->is($large));
    }
}
