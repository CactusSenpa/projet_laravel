@extends('layouts.admin')
@section('title', $product->exists ? 'Modifier le produit' : 'Nouveau produit')
@section('content')
<form method="post" enctype="multipart/form-data" action="{{ $product->exists ? route('admin.products.update', $product) : route('admin.products.store') }}" class="row g-3 bg-white p-4 rounded">
    @csrf
    @if ($product->exists) @method('PUT') @endif
    <div class="col-md-6"><label class="form-label">Nom</label><input class="form-control" name="name" value="{{ old('name', $product->name) }}" required></div>
    <div class="col-md-3"><label class="form-label">Référence</label><input class="form-control" name="reference" value="{{ old('reference', $product->reference) }}" required></div>
    <div class="col-md-3">
        <label class="form-label">Catégorie</label>
        <select name="category_id" class="form-select" required>
            @foreach ($categories as $category)
                <option value="{{ $category->id }}" @selected(old('category_id', $product->category_id) == $category->id)>{{ $category->name }}</option>
            @endforeach
        </select>
    </div>
    <div class="col-12"><label class="form-label">Description</label><textarea class="form-control" name="description">{{ old('description', $product->description) }}</textarea></div>
    <div class="col-md-2"><label class="form-label">W</label><input class="form-control" type="number" name="power_w" value="{{ old('power_w', $product->power_w) }}"></div>
    <div class="col-md-2"><label class="form-label">V</label><input class="form-control" type="number" name="voltage_v" value="{{ old('voltage_v', $product->voltage_v) }}"></div>
    <div class="col-md-2"><label class="form-label">Wh</label><input class="form-control" type="number" name="capacity_wh" value="{{ old('capacity_wh', $product->capacity_wh) }}"></div>
    <div class="col-md-2"><label class="form-label">Ah</label><input class="form-control" type="number" step="0.01" name="capacity_ah" value="{{ old('capacity_ah', $product->capacity_ah) }}"></div>
    <div class="col-md-2"><label class="form-label">Pic W</label><input class="form-control" type="number" name="surge_power_w" value="{{ old('surge_power_w', $product->surge_power_w) }}"></div>
    <div class="col-md-2"><label class="form-label">Prix jour</label><input class="form-control" type="number" step="0.01" name="daily_price" value="{{ old('daily_price', $product->daily_price) }}" required></div>
    <div class="col-md-2"><label class="form-label">Caution</label><input class="form-control" type="number" step="0.01" name="deposit" value="{{ old('deposit', $product->deposit ?? 0) }}" required></div>
    <div class="col-md-2"><label class="form-label">Quantité</label><input class="form-control" type="number" name="quantity" value="{{ old('quantity', $product->quantity ?? 1) }}" required></div>
    <div class="col-md-4"><label class="form-label">Image</label><input class="form-control" type="file" name="image" accept="image/jpeg,image/png,image/webp"></div>
    <div class="col-12"><div class="form-check"><input class="form-check-input" type="checkbox" name="is_active" value="1" @checked(old('is_active', $product->is_active ?? true))><label class="form-check-label">Actif</label></div></div>
    <div class="col-12"><button class="btn btn-solar">Enregistrer</button></div>
</form>
@endsection
