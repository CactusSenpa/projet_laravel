@extends('layouts.app')

@section('title', 'Reservation History')

@section('content')
<div class="container py-5">
    <h1 class="h3 mb-4">Reservation History</h1>
    @forelse ($reservations as $reservation)
        <div class="card border-0 shadow-sm mb-3">
            <div class="card-body">
                <div class="d-flex justify-content-between flex-wrap gap-2">
                    <h2 class="h5 mb-0">Réservation #{{ $clientReservationNumbers[$reservation->id] }}</h2>
                    <span class="badge text-bg-secondary">{{ $reservation->statusLabel() }}</span>
                </div>
                <hr>
                <div class="row g-2 small">
                    <div class="col-md-4"><strong>Dates :</strong> {{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}</div>
                    <div class="col-md-4"><strong>Lieu :</strong> {{ $reservation->location }}</div>
                    <div class="col-md-4"><strong>Total estimé :</strong> {{ tnd($reservation->estimated_price) }}</div>
                    <div class="col-12"><strong>Matériel :</strong> {{ $reservation->pack?->name ?? 'Produit(s) à l’unité' }}</div>
                    @if ($reservation->products->isNotEmpty())
                        <div class="col-12">{{ $reservation->products->map(fn ($item) => ($item->quantity > 1 ? $item->quantity.'× ' : '').($item->product?->name ?? 'Produit'))->implode(', ') }}</div>
                    @endif
                </div>
            </div>
        </div>
    @empty
        <p class="text-muted">Vous n’avez encore aucune réservation associée à votre compte.</p>
    @endforelse
    {{ $reservations->links() }}
</div>
@endsection
