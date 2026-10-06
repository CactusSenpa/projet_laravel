@extends('layouts.admin')
@section('title', 'Appareils')
@section('content')
<form method="post" action="{{ route('admin.appliances.store') }}" class="row g-2 bg-white p-3 rounded mb-4">
    @csrf
    <div class="col-md-3"><input class="form-control" name="name" placeholder="Nom" required></div>
    <div class="col-md-2"><input class="form-control" type="number" name="default_power_w" placeholder="W" required></div>
    <div class="col-md-2"><input class="form-control" type="number" step="0.1" name="default_duration_hours" placeholder="Heures" value="4" required></div>
    <div class="col-md-2"><input class="form-control" type="number" step="0.1" name="startup_factor" value="3" required></div>
    <div class="col-md-2"><input class="form-control" name="category" placeholder="Catégorie"></div>
    <div class="col-md-1"><div class="form-check"><input class="form-check-input" type="checkbox" name="has_startup_surge" value="1"><label class="form-check-label">Pic</label></div></div>
    <div class="col-12"><button class="btn btn-solar">Ajouter</button></div>
</form>
<table class="table bg-white">
    <thead><tr><th>Nom</th><th>W</th><th>Heures</th><th>Pic</th><th></th></tr></thead>
    <tbody>
    @foreach ($appliances as $appliance)
        <tr>
            <td>{{ $appliance->name }}</td>
            <td>{{ $appliance->default_power_w }}</td>
            <td>{{ $appliance->default_duration_hours }}</td>
            <td>{{ $appliance->has_startup_surge ? 'oui ×'.$appliance->startup_factor : 'non' }}</td>
            <td>
                <form method="post" action="{{ route('admin.appliances.destroy', $appliance) }}">
                    @csrf @method('DELETE')
                    <button class="btn btn-link text-danger p-0">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $appliances->links() }}
@endsection
