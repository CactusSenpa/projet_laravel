@extends('layouts.app')

@section('title', 'Calculateur énergétique')

@section('content')
<div class="container py-5">
    <h1>Calculateur énergétique</h1>
    <p class="text-muted">Aucune connaissance solaire n’est nécessaire. Nous convertissons vos appareils en besoin de batterie, onduleur et panneaux.</p>

    @if ($errors->any())
        @include('components.alert', ['type' => 'danger', 'message' => $errors->first()])
    @endif

    <form method="post" action="{{ route('calculator.calculate') }}" id="calc-form">
        @csrf
        <div class="calc-step">
            <div class="card step-card">
                <div class="card-body">
                    <h2 class="h4">Étape 1 — Quel est votre projet ?</h2>
                    <div class="row g-3 mt-1">
                        @foreach (['evenement' => 'Événement', 'chantier' => 'Chantier', 'stand' => 'Stand', 'autre' => 'Autre'] as $value => $label)
                            <div class="col-md-3">
                                <label class="w-100">
                                    <input class="btn-check" type="radio" name="project_type" value="{{ $value }}" @checked($value === 'evenement')>
                                    <span class="btn btn-outline-dark w-100 py-3">{{ $label }}</span>
                                </label>
                            </div>
                        @endforeach
                    </div>
                    <button type="button" class="btn btn-solar mt-4" data-next-step="1">Continuer</button>
                </div>
            </div>
        </div>

        <div class="calc-step">
            <div class="card step-card">
                <div class="card-body">
                    <h2 class="h4">Étape 2 — Quels appareils utilisez-vous ?</h2>
                    <div class="row g-2 mb-3">
                        <div class="col-md-8">
                            <select id="preset-appliance" class="form-select">
                                @foreach ($appliances as $appliance)
                                    <option value="{{ $appliance->id }}">{{ $appliance->name }} ({{ $appliance->default_power_w }} W)</option>
                                @endforeach
                                <option value="custom">Appareil personnalisé</option>
                            </select>
                        </div>
                        <div class="col-md-4">
                            <button type="button" class="btn btn-dark w-100" id="add-appliance">+ Ajouter un appareil</button>
                        </div>
                    </div>
                    <div id="appliance-rows"></div>
                    <p class="small text-muted">La quantité doit être supérieure à 0. La durée correspond aux heures d’utilisation sur la période.</p>
                    <button type="button" class="btn btn-outline-secondary" data-next-step="0">Retour</button>
                    <button type="button" class="btn btn-solar" data-next-step="2">Continuer</button>
                </div>
            </div>
        </div>

        <div class="calc-step">
            <div class="card step-card">
                <div class="card-body">
                    <h2 class="h4">Étape 3 — Batterie et calcul</h2>
                    <label class="form-label">Type de batterie (DoD)</label>
                    <select name="battery_type" class="form-select w-auto">
                        <option value="lithium">Lithium (DoD 80 %) — recommandé</option>
                        <option value="lead">Plomb (DoD 50 %)</option>
                    </select>
                    <p class="small text-muted mt-3">Le DoD indique la partie de la capacité de la batterie que nous pouvons utiliser sans réduire excessivement sa durée de vie.</p>
                    <button type="button" class="btn btn-outline-secondary" data-next-step="1">Retour</button>
                    <button type="submit" class="btn btn-solar">Calculer</button>
                </div>
            </div>
        </div>
    </form>
</div>
<script type="application/json" id="appliance-library">{!! $appliances->toJson() !!}</script>
@endsection

@push('scripts')
<script src="{{ asset('js/calculator.js') }}"></script>
@endpush
