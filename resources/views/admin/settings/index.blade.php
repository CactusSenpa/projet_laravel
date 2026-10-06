@extends('layouts.admin')
@section('title', 'Paramètres')
@section('content')
<form method="post" action="{{ route('admin.settings.update') }}" class="row g-3 bg-white p-4 rounded col-lg-8">
    @csrf @method('PUT')
    @foreach ([
        'company_name' => 'Nom de l’entreprise',
        'whatsapp_number' => 'WhatsApp (indicatif pays, ex. 21620000000)',
        'default_system_efficiency' => 'Rendement système (0.85)',
        'default_energy_margin' => 'Marge énergie (1.20)',
        'default_solar_hours' => 'Heures solaires (4.5)',
        'default_inverter_factor' => 'Facteur onduleur (1.25)',
        'default_lithium_dod' => 'DoD lithium',
        'default_lead_dod' => 'DoD plomb',
        'default_battery_voltage' => 'Tension batterie (V)',
        'delivery_fee' => 'Frais de livraison (TND)',
    ] as $key => $label)
        <div class="col-md-6">
            <label class="form-label">{{ $label }}</label>
            <input class="form-control" name="{{ $key }}" value="{{ old($key, $settings[$key] ?? '') }}" required>
        </div>
    @endforeach
    <div class="col-12"><button class="btn btn-solar">Enregistrer</button></div>
</form>
@endsection
