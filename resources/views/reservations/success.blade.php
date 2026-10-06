@extends('layouts.app')

@section('title', 'Demande envoyée')

@section('content')
<div class="container py-5 col-lg-7">
    <div class="card shadow-sm">
        <div class="card-body p-4">
            <h1 class="h3">Demande n°{{ $reservation->id }} enregistrée</h1>
            <p>Merci {{ $reservation->customer_name }}. Notre équipe vous confirme la disponibilité sous peu.</p>
            <ul>
                <li>Pack : {{ $reservation->pack?->name ?? 'à confirmer' }}</li>
                <li>Dates : {{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}</li>
                <li>Lieu : {{ $reservation->location }}</li>
                <li>Total estimé : {{ tnd($reservation->estimated_price) }}</li>
                <li>Caution : {{ tnd($reservation->deposit_amount) }}</li>
            </ul>
            <a class="btn btn-success btn-lg" href="{{ $whatsappMessageUrl }}" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp"></i> Continuer sur WhatsApp
            </a>
        </div>
    </div>
</div>
@endsection
