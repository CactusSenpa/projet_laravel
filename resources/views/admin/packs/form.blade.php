@extends('layouts.admin')
@section('title', $pack->exists ? 'Modifier le pack' : 'Nouveau pack')
@section('content')
<form method="post" enctype="multipart/form-data" action="{{ $pack->exists ? route('admin.packs.update', $pack) : route('admin.packs.store') }}" class="row g-3 bg-white p-4 rounded">
    @csrf
    @if ($pack->exists) @method('PUT') @endif
    <div class="col-md-6"><label class="form-label">Nom</label><input class="form-control" name="name" value="{{ old('name', $pack->name) }}" required></div>
    <div class="col-md-3"><label class="form-label">Prix / jour</label><input class="form-control" type="number" step="0.01" name="price_per_day" value="{{ old('price_per_day', $pack->price_per_day) }}" required></div>
    <div class="col-md-3"><label class="form-label">Caution</label><input class="form-control" type="number" step="0.01" name="deposit" value="{{ old('deposit', $pack->deposit ?? 0) }}" required></div>
    <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description">{{ old('description', $pack->description) }}</textarea></div>
    <div class="col-md-4"><label class="form-label">Capacité Wh</label><input class="form-control" type="number" name="energy_capacity_wh" value="{{ old('energy_capacity_wh', $pack->energy_capacity_wh) }}" required></div>
    <div class="col-md-4"><label class="form-label">Puissance continue W</label><input class="form-control" type="number" name="continuous_power_w" value="{{ old('continuous_power_w', $pack->continuous_power_w) }}" required></div>
    <div class="col-md-4"><label class="form-label">Pic W</label><input class="form-control" type="number" name="surge_power_w" value="{{ old('surge_power_w', $pack->surge_power_w) }}"></div>
    <div class="col-12"><label class="form-label">Usages (séparés par des virgules)</label>
        <input class="form-control" name="recommended_uses" value="{{ old('recommended_uses', is_array($pack->recommended_uses) ? implode(', ', $pack->recommended_uses) : '') }}">
    </div>
    <div class="col-md-6"><label class="form-label">Image</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp"></div>
    <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $pack->is_active ?? true))><label class="form-check-label">Actif</label></div></div>
    <div class="col-12">
        <h2 class="h6">Contenu</h2>
        @foreach ($products as $product)
            <div class="d-flex gap-2 align-items-center mb-1">
                <span class="flex-grow-1">{{ $product->name }}</span>
                <input class="form-control" style="width:90px" type="number" min="0" name="product_qty[{{ $product->id }}]" value="{{ $selected[$product->id] ?? 0 }}">
            </div>
        @endforeach
    </div>
    <div class="col-12"><button class="btn btn-solar">Enregistrer</button></div>
</form>
@endsection
