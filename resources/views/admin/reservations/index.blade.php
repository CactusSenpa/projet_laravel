@extends('layouts.admin')
@section('title', 'Réservations')
@section('content')
<table class="table bg-white">
    <thead><tr><th>#</th><th>Client</th><th>Téléphone</th><th>Pack / Matériel</th><th>Dates</th><th>Total</th><th>Statut</th></tr></thead>
    <tbody>
    @foreach ($reservations as $reservation)
        <tr>
            <td><a href="{{ route('admin.reservations.show', $reservation) }}">{{ $reservation->id }}</a></td>
            <td>{{ $reservation->customer_name }}</td>
            <td>{{ $reservation->customer_phone }}</td>
            <td>
                @if ($reservation->pack)
                    <span class="badge text-bg-primary">Pack</span> {{ $reservation->pack->name }}
                @elseif ($reservation->products->isNotEmpty())
                    <span class="badge text-bg-secondary">Produit</span>
                    {{ $reservation->products->map(fn($p) => ($p->quantity > 1 ? $p->quantity.'× ' : '').$p->product?->name)->implode(', ') }}
                @else
                    <span class="text-muted">À confirmer</span>
                @endif
            </td>
            <td>{{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}</td>
            <td>{{ tnd($reservation->estimated_price) }}</td>
            <td>{{ $reservation->statusLabel() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $reservations->links() }}
@endsection
