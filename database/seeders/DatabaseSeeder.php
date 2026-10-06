<?php

namespace Database\Seeders;

use App\Models\Appliance;
use App\Models\Category;
use App\Models\Pack;
use App\Models\Product;
use App\Models\Setting;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'admin@wattloc.test'],
            [
                'name' => 'Administrateur WattLoc',
                'phone' => '20000000',
                'password' => Hash::make('password'),
                'role' => 'admin',
                'is_active' => true,
            ]
        );

        $settings = [
            'company_name' => 'WattLoc',
            'whatsapp_number' => '21620000000',
            'default_system_efficiency' => '0.85',
            'default_energy_margin' => '1.20',
            'default_solar_hours' => '4.5',
            'default_inverter_factor' => '1.25',
            'default_lithium_dod' => '0.80',
            'default_lead_dod' => '0.50',
            'default_battery_voltage' => '48',
            'delivery_fee' => '30',
        ];

        foreach ($settings as $key => $value) {
            Setting::putValue($key, $value);
        }

        $categories = [
            ['name' => 'Panneaux', 'slug' => 'panneaux', 'description' => 'Panneaux solaires photovoltaïques.'],
            ['name' => 'Batteries', 'slug' => 'batteries', 'description' => 'Stockage lithium et plomb.'],
            ['name' => 'Onduleurs', 'slug' => 'onduleurs', 'description' => 'Onduleurs 230 V.'],
            ['name' => 'Chargeurs / MPPT', 'slug' => 'chargeurs-mppt', 'description' => 'Régulateurs et MPPT.'],
            ['name' => 'Accessoires', 'slug' => 'accessoires', 'description' => 'Câbles, coffrets, supports.'],
            ['name' => 'Générateurs', 'slug' => 'generateurs', 'description' => 'Groupes électrogènes d’appoint.'],
        ];

        $categoryModels = [];
        foreach ($categories as $category) {
            $categoryModels[$category['slug']] = Category::query()->updateOrCreate(
                ['slug' => $category['slug']],
                $category
            );
        }

        $products = [
            ['slug' => 'panneaux', 'name' => 'Panneau solaire 400 W', 'reference' => 'PV-400', 'power_w' => 400, 'voltage_v' => 24, 'daily_price' => 15, 'deposit' => 120, 'quantity' => 20, 'description' => 'Panneau monocristallin 400 W, idéal pour compléter un pack événement.'],
            ['slug' => 'panneaux', 'name' => 'Panneau solaire 550 W', 'reference' => 'PV-550', 'power_w' => 550, 'voltage_v' => 48, 'daily_price' => 20, 'deposit' => 150, 'quantity' => 16, 'description' => 'Haut rendement pour chantiers et recharge diurne.'],
            ['slug' => 'batteries', 'name' => 'Batterie lithium 5 kWh 48 V', 'reference' => 'BAT-L5', 'power_w' => null, 'voltage_v' => 48, 'capacity_wh' => 5000, 'capacity_ah' => 104, 'daily_price' => 80, 'deposit' => 900, 'quantity' => 6, 'description' => 'Lithium LiFePO4, DoD élevé, silencieuse.'],
            ['slug' => 'batteries', 'name' => 'Batterie lithium 10 kWh 48 V', 'reference' => 'BAT-L10', 'power_w' => null, 'voltage_v' => 48, 'capacity_wh' => 10000, 'capacity_ah' => 208, 'daily_price' => 140, 'deposit' => 1600, 'quantity' => 4, 'description' => 'Grande autonomie pour soirées et stands.'],
            ['slug' => 'batteries', 'name' => 'Batterie plomb 200 Ah 12 V', 'reference' => 'BAT-P200', 'power_w' => null, 'voltage_v' => 12, 'capacity_wh' => 2400, 'capacity_ah' => 200, 'daily_price' => 25, 'deposit' => 250, 'quantity' => 10, 'description' => 'Solution économique, DoD plus faible.'],
            ['slug' => 'onduleurs', 'name' => 'Onduleur 1000 W', 'reference' => 'INV-1000', 'power_w' => 1000, 'surge_power_w' => 2000, 'voltage_v' => 230, 'daily_price' => 20, 'deposit' => 180, 'quantity' => 8, 'description' => 'Pour éclairage, TV et petit froid.'],
            ['slug' => 'onduleurs', 'name' => 'Onduleur 3000 W', 'reference' => 'INV-3000', 'power_w' => 3000, 'surge_power_w' => 6000, 'voltage_v' => 230, 'daily_price' => 45, 'deposit' => 400, 'quantity' => 5, 'description' => 'Événements, sono et mixeurs.'],
            ['slug' => 'onduleurs', 'name' => 'Onduleur 5000 W', 'reference' => 'INV-5000', 'power_w' => 5000, 'surge_power_w' => 10000, 'voltage_v' => 230, 'daily_price' => 70, 'deposit' => 650, 'quantity' => 3, 'description' => 'Outils électroportatifs et pics de démarrage.'],
            ['slug' => 'chargeurs-mppt', 'name' => 'Régulateur MPPT 40 A', 'reference' => 'MPPT-40', 'power_w' => null, 'voltage_v' => 48, 'daily_price' => 15, 'deposit' => 120, 'quantity' => 8, 'description' => 'Charge solaire optimisée.'],
            ['slug' => 'accessoires', 'name' => 'Kit câbles et protections', 'reference' => 'ACC-CABLES', 'daily_price' => 8, 'deposit' => 40, 'quantity' => 15, 'description' => 'MC4, DC, AC, disjoncteurs.'],
            ['slug' => 'generateurs', 'name' => 'Groupe électrogène 3 kVA', 'reference' => 'GEN-3K', 'power_w' => 2400, 'surge_power_w' => 3300, 'daily_price' => 60, 'deposit' => 500, 'quantity' => 2, 'description' => 'Appoint thermique si le solaire est insuffisant.'],
        ];

        $productModels = [];
        foreach ($products as $item) {
            $slug = $item['slug'];
            unset($item['slug']);
            $item['category_id'] = $categoryModels[$slug]->id;
            $item['is_active'] = true;
            $item['image'] = null;
            $productModels[$item['reference']] = Product::query()->updateOrCreate(
                ['reference' => $item['reference']],
                $item
            );
        }

        $packs = [
            [
                'name' => 'Pack Stand Marché',
                'description' => 'Idéal pour un stand, un marché ou un petit point de vente. Installation simple, silencieux.',
                'price_per_day' => 90,
                'deposit' => 700,
                'energy_capacity_wh' => 4500,
                'continuous_power_w' => 1200,
                'surge_power_w' => 2200,
                'recommended_uses' => ['Stand', 'Marché', 'Caisse / éclairage'],
                'items' => ['BAT-L5' => 1, 'INV-1000' => 1, 'PV-400' => 1, 'MPPT-40' => 1, 'ACC-CABLES' => 1],
            ],
            [
                'name' => 'Pack Événement 1 Nuit',
                'description' => 'Éclairage, sono légère, TV et réfrigérateur pour une soirée ou un mariage.',
                'price_per_day' => 180,
                'deposit' => 1400,
                'energy_capacity_wh' => 9500,
                'continuous_power_w' => 3500,
                'surge_power_w' => 6500,
                'recommended_uses' => ['Mariage', 'Anniversaire', 'Concert léger'],
                'items' => ['BAT-L10' => 1, 'INV-3000' => 1, 'PV-550' => 2, 'MPPT-40' => 1, 'ACC-CABLES' => 1],
            ],
            [
                'name' => 'Pack Chantier Journée',
                'description' => 'Conçu pour perceuses, meuleuses et éclairage de chantier, avec marge sur les pics.',
                'price_per_day' => 220,
                'deposit' => 1800,
                'energy_capacity_wh' => 12000,
                'continuous_power_w' => 5500,
                'surge_power_w' => 10000,
                'recommended_uses' => ['Chantier', 'Bureau temporaire', 'Outillage'],
                'items' => ['BAT-L10' => 1, 'INV-5000' => 1, 'PV-550' => 4, 'MPPT-40' => 1, 'ACC-CABLES' => 1],
            ],
        ];

        foreach ($packs as $packData) {
            $items = $packData['items'];
            unset($packData['items']);
            $packData['is_active'] = true;
            $pack = Pack::query()->updateOrCreate(['name' => $packData['name']], $packData);
            $sync = [];
            foreach ($items as $reference => $qty) {
                $sync[$productModels[$reference]->id] = ['quantity' => $qty];
            }
            $pack->products()->sync($sync);
        }

        $appliances = [
            ['name' => 'Éclairage LED', 'default_power_w' => 20, 'default_duration_hours' => 5, 'has_startup_surge' => false, 'startup_factor' => 1, 'category' => 'eclairage'],
            ['name' => 'Télévision', 'default_power_w' => 120, 'default_duration_hours' => 4, 'has_startup_surge' => false, 'startup_factor' => 1, 'category' => 'multimedia'],
            ['name' => 'Réfrigérateur', 'default_power_w' => 150, 'default_duration_hours' => 6, 'has_startup_surge' => true, 'startup_factor' => 3, 'category' => 'froid'],
            ['name' => 'Ordinateur', 'default_power_w' => 100, 'default_duration_hours' => 8, 'has_startup_surge' => false, 'startup_factor' => 1, 'category' => 'informatique'],
            ['name' => 'Enceinte', 'default_power_w' => 100, 'default_duration_hours' => 4, 'has_startup_surge' => false, 'startup_factor' => 1, 'category' => 'audio'],
            ['name' => 'DJ / table de mixage', 'default_power_w' => 250, 'default_duration_hours' => 5, 'has_startup_surge' => false, 'startup_factor' => 1, 'category' => 'audio'],
            ['name' => 'Perceuse', 'default_power_w' => 800, 'default_duration_hours' => 2, 'has_startup_surge' => true, 'startup_factor' => 3, 'category' => 'outillage'],
            ['name' => 'Meuleuse', 'default_power_w' => 1000, 'default_duration_hours' => 1, 'has_startup_surge' => true, 'startup_factor' => 3, 'category' => 'outillage'],
            ['name' => 'Pompe', 'default_power_w' => 750, 'default_duration_hours' => 2, 'has_startup_surge' => true, 'startup_factor' => 4, 'category' => 'outillage'],
            ['name' => 'Chargeur téléphone', 'default_power_w' => 15, 'default_duration_hours' => 4, 'has_startup_surge' => false, 'startup_factor' => 1, 'category' => 'informatique'],
            ['name' => 'Imprimante', 'default_power_w' => 50, 'default_duration_hours' => 4, 'has_startup_surge' => false, 'startup_factor' => 1, 'category' => 'informatique'],
            ['name' => 'Ventilateur', 'default_power_w' => 60, 'default_duration_hours' => 8, 'has_startup_surge' => true, 'startup_factor' => 2, 'category' => 'confort'],
        ];

        foreach ($appliances as $appliance) {
            Appliance::query()->updateOrCreate(['name' => $appliance['name']], $appliance);
        }
    }
}
