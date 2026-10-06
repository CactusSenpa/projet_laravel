@extends('layouts.admin')
@section('title', 'Disponibilité')
@section('content')
<table class="table bg-white">
    <thead><tr><th>Date</th><th>Pack / produit</th><th>Total</th><th>Réservé</th><th>Dispo</th></tr></thead>
    <tbody>
    @forelse ($availabilities as $row)
        <tr>
            <td>{{ $row->date->format('d/m/Y') }}</td>
            <td>{{ $row->pack?->name ?? $row->product?->name }}</td>
            <td>{{ $row->quantity_total }}</td>
            <td>{{ $row->quantity_reserved }}</td>
            <td>{{ $row->quantity_available }}</td>
        </tr>
    @empty
        <tr><td colspan="5">Aucune ligne pour l’instant. Les disponibilités se remplissent à chaque réservation.</td></tr>
    @endforelse
    </tbody>
</table>
{{ $availabilities->links() }}
@endsection
