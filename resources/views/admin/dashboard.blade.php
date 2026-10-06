@extends('layouts.admin')
@section('title', 'Dashboard')
@section('content')
<div class="row g-3 mb-4">
    <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm">Produits<br><strong>{{ $productsCount }}</strong></div></div>
    <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm">Packs<br><strong>{{ $packsCount }}</strong></div></div>
    <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm">En attente<br><strong>{{ $pendingReservations }}</strong></div></div>
    <div class="col-md-3"><div class="p-3 bg-white rounded shadow-sm">Confirmées<br><strong>{{ $confirmedReservations }}</strong></div></div>
</div>
<h2 class="h5">Dernières réservations</h2>
<table class="table bg-white">
    <thead><tr><th>#</th><th>Client</th><th>Pack</th><th>Dates</th><th>Statut</th></tr></thead>
    <tbody>
    @foreach ($latestReservations as $reservation)
        <tr>
            <td><a href="{{ route('admin.reservations.show', $reservation) }}">{{ $reservation->id }}</a></td>
            <td>{{ $reservation->customer_name }}</td>
            <td>{{ $reservation->pack?->name }}</td>
            <td>{{ $reservation->start_date->format('d/m') }} - {{ $reservation->end_date->format('d/m') }}</td>
            <td>{{ $reservation->statusLabel() }}</td>
        </tr>
    @endforeach
    </tbody>
</table>
@endsection
