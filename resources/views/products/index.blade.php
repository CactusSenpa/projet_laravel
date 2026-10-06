@extends('layouts.app')

@section('title', 'Catalogue de matériel énergétique')
@section('meta_description', 'Louez panneaux, batteries, onduleurs et accessoires en Tunisie.')

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('home') }}">Accueil</a></li>
            <li class="breadcrumb-item active">Catalogue</li>
        </ol>
    </nav>
    <h1 class="mb-4">Catalogue</h1>
    <form class="row g-2 mb-4" method="get">
        <div class="col-md-3">
            <select name="category" class="form-select">
                <option value="">Toutes les catégories</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-md-2">
            <input class="form-control" type="number" name="power_min" placeholder="W min" value="{{ request('power_min') }}">
        </div>
        <div class="col-md-2">
            <input class="form-control" type="number" name="power_max" placeholder="W max" value="{{ request('power_max') }}">
        </div>
        <div class="col-md-2">
            <input class="form-control" type="number" name="price_max" placeholder="Prix max TND" value="{{ request('price_max') }}">
        </div>
        <div class="col-md-2 d-flex align-items-center">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="available" value="1" @checked(request('available'))>
                <label class="form-check-label">Disponible</label>
            </div>
        </div>
        <div class="col-md-1">
            <button class="btn btn-dark w-100">Filtrer</button>
        </div>
    </form>
    <div class="row g-4">
        @forelse ($products as $product)
            <div class="col-sm-6 col-lg-4">
                @include('components.product-card', ['product' => $product])
            </div>
        @empty
            <p>Aucun produit ne correspond à ces filtres.</p>
        @endforelse
    </div>
    <div class="mt-4">{{ $products->links() }}</div>
</div>
@endsection
