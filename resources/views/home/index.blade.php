@extends('layouts.app')

@section('title', 'Location d’énergie temporaire en Tunisie')

@section('content')
<section class="hero">
    <div class="container">
        <div class="col-lg-8">
            <p class="text-warning fw-semibold mb-2">WattLoc • Tunisie • TND</p>
            <h1>Besoin d'électricité temporaire ? Nous avons la solution.</h1>
            <p class="lead mt-3">Location de panneaux solaires, batteries, onduleurs et packs énergétiques pour événements, stands et chantiers.</p>
            <div class="d-flex flex-wrap gap-2 mt-4">
                <a class="btn btn-solar btn-lg" href="{{ route('calculator.index') }}">Calculer mes besoins</a>
                <a class="btn btn-outline-light btn-lg" href="{{ route('packs.index') }}">Voir les packs</a>
                <a class="btn btn-light btn-lg" href="{{ route('reservation.create') }}">Réserver</a>
                <a class="btn btn-success btn-lg" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">WhatsApp</a>
            </div>
        </div>
    </div>
</section>

<section class="py-5">
    <div class="container">
        <h2 class="mb-4">Pourquoi nous choisir</h2>
        <div class="row g-4">
            @foreach (['Installation simple', 'Énergie temporaire', 'Packs adaptés', 'Livraison disponible', 'Assistance technique'] as $item)
                <div class="col-md-4 col-lg">
                    <div class="card step-card h-100">
                        <div class="card-body">
                            <i class="bi bi-check-circle-fill text-warning fs-3"></i>
                            <h3 class="h6 mt-2">{{ $item }}</h3>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <div class="d-flex justify-content-between align-items-center mb-3">
            <h2>Packs populaires</h2>
            <a href="{{ route('packs.index') }}">Tous les packs</a>
        </div>
        <div class="row g-4">
            @foreach ($packs as $pack)
                <div class="col-md-4">
                    @include('components.pack-card', ['pack' => $pack])
                </div>
            @endforeach
        </div>
    </div>
</section>

<section class="pb-5">
    <div class="container">
        <h2 class="mb-4">Comment ça marche</h2>
        <div class="row g-3">
            @foreach (['Décrivez vos besoins', 'Calculez votre consommation', 'Choisissez votre solution', 'Réservez'] as $i => $step)
                <div class="col-md-3">
                    <div class="p-4 bg-white rounded-3 shadow-sm h-100">
                        <span class="badge text-bg-warning text-dark">{{ $i + 1 }}</span>
                        <p class="fw-semibold mt-3 mb-0">{{ $step }}</p>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="text-center mt-5">
            <a class="btn btn-solar btn-lg me-2" href="{{ route('calculator.index') }}">Lancer le calculateur</a>
            <a class="btn btn-success btn-lg" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">WhatsApp</a>
        </div>
    </div>
</section>
@endsection
