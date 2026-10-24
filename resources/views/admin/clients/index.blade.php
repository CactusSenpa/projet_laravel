@extends('layouts.admin')

@section('title', 'Clients')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-3">
    <h1 class="h3 mb-0">Clients</h1>
    <a class="btn btn-solar" href="{{ route('admin.clients.create') }}">Nouveau client</a>
</div>
<div class="table-responsive bg-white shadow-sm rounded">
    <table class="table table-hover mb-0 align-middle">
        <thead><tr><th>Nom</th><th>E-mail</th><th>Téléphone</th><th>Réservations</th><th>Statut</th><th></th></tr></thead>
        <tbody>
        @forelse ($clients as $client)
            <tr>
                <td>{{ $client->name }}</td>
                <td>{{ $client->email }}</td>
                <td>{{ $client->phone ?: '—' }}</td>
                <td>{{ $client->reservations_count }}</td>
                <td><span class="badge {{ $client->is_active ? 'text-bg-success' : 'text-bg-secondary' }}">{{ $client->is_active ? 'Actif' : 'Désactivé' }}</span></td>
                <td class="text-end">
                    <a class="btn btn-sm btn-outline-primary" href="{{ route('admin.clients.edit', $client) }}">Modifier</a>
                    <form class="d-inline" method="post" action="{{ route('admin.clients.destroy', $client) }}" onsubmit="return confirm('Supprimer ce client ?');">
                        @csrf
                        @method('DELETE')
                        <button class="btn btn-sm btn-outline-danger">Supprimer</button>
                    </form>
                </td>
            </tr>
        @empty
            <tr><td colspan="6" class="text-center text-muted py-4">Aucun client.</td></tr>
        @endforelse
        </tbody>
    </table>
</div>
<div class="mt-3">{{ $clients->links() }}</div>
@endsection
