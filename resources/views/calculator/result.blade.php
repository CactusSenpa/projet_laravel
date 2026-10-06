@extends('layouts.app')

@section('title', 'Résultat du calculateur')

@section('content')
<div class="container py-5">
    <h1>Votre besoin énergétique</h1>
    <p class="lead">Environ <strong>{{ number_format($quote->total_energy_wh / 1000, 2, ',', ' ') }} kWh</strong> d’usage, soit
        <strong>{{ number_format($quote->recommended_battery_wh / 1000, 2, ',', ' ') }} kWh</strong> de batterie après marges.</p>

    <div class="row g-3 mb-4">
        <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm"><small>Énergie brute</small><div class="fw-bold">{{ $quote->total_energy_wh }} Wh</div></div></div>
        <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm"><small>Avec marge 20 %</small><div class="fw-bold">{{ $quote->energy_with_margin_wh }} Wh</div></div></div>
        <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm"><small>Puissance simultanée</small><div class="fw-bold">{{ $quote->max_simultaneous_power_w }} W</div></div></div>
        <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm"><small>Pic de démarrage</small><div class="fw-bold">{{ $quote->peak_power_w }} W</div></div></div>
    </div>

    <div class="row g-3 mb-4">
        <div class="col-md-4"><div class="p-3 bg-dark text-white rounded"><small>Batterie recommandée</small><div class="h5">{{ $quote->recommended_battery_wh }} Wh • {{ $quote->recommended_battery_ah }} Ah / {{ $quote->battery_voltage }} V</div></div></div>
        <div class="col-md-4"><div class="p-3 bg-dark text-white rounded"><small>Onduleur recommandé</small><div class="h5">{{ $quote->recommended_inverter_w }} W continus</div></div></div>
        <div class="col-md-4"><div class="p-3 bg-dark text-white rounded"><small>Panneaux (recharge diurne)</small><div class="h5">{{ $quote->recommended_solar_w }} Wc</div></div></div>
    </div>

    <p class="small text-muted">Le rendement du système (pertes câbles, onduleur, charge) est déjà intégré. Le DoD évite de vider complètement la batterie.</p>

    <h2 class="h4 mt-4">Packs compatibles</h2>
    @if ($compatible->isEmpty())
        @include('components.alert', ['type' => 'warning', 'message' => 'Aucun pack ne correspond exactement à vos besoins. Nous vous recommandons de contacter notre équipe.'])
        <a class="btn btn-success" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">Contacter sur WhatsApp</a>
    @else
        <div class="row g-4">
            @foreach ($compatible as $pack)
                <div class="col-md-4">
                    @include('components.pack-card', ['pack' => $pack])
                    <a class="btn btn-dark w-100 mt-2" href="{{ route('reservation.create', ['pack' => $pack->id, 'quote' => $quote->id]) }}">Réserver</a>
                </div>
            @endforeach
        </div>
    @endif
</div>
@endsection
