@extends('layouts.admin')
@section('title', 'Réservations')
@section('content')
<table class="table bg-white">
    <thead><tr><th>#</th><th>Client</th><th>Téléphone</th><th>Pack</th><th>Dates</th><th>Total</th><th>Statut</th></tr></thead>
    <tbody>
    @foreach ($reservations as $reservation)
        <tr>
            <td><a href="{{ route('admin.reservations.show', $reservation) }}">{{ $reservation->id }}</a></td>
            <td>{{ $reservation->customer_name }}</td>
            <td>{{ $reservation->customer_phone }}</td>
            <td>{{ $reservation->pack?->name }}</td>
            <td>{{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}</td>
            <td>{{ tnd($reservation->estimated_price) }}</td>
            <td>{{ $reservation->statusLabel() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $reservations->links() }}
@endsection
