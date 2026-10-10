@extends('layouts.app')

@section('title', $product->name)

@section('content')
<div class="container py-5">
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item"><a href="{{ route('catalogue') }}">Catalogue</a></li>
            <li class="breadcrumb-item active">{{ $product->name }}</li>
        </ol>
    </nav>
    <div class="row g-4">
        <div class="col-md-6">
            @if ($product->image)
                <img class="img-fluid rounded" src="{{ asset('storage/'.$product->image) }}" alt="{{ $product->name }}">
            @else
                <div class="placeholder-visual rounded" style="height: 320px"><i class="bi bi-lightning-charge-fill"></i></div>
            @endif
        </div>
        <div class="col-md-6">
            <span class="badge text-bg-dark">{{ $product->category->name }}</span>
            <h1 class="h2 mt-2">{{ $product->name }}</h1>
            <p class="text-muted">Référence {{ $product->reference }}</p>
            <p>{{ $product->description }}</p>
            <ul class="list-group mb-3">
                @if ($product->power_w)<li class="list-group-item">Puissance : {{ $product->power_w }} W</li>@endif
                @if ($product->voltage_v)<li class="list-group-item">Tension : {{ $product->voltage_v }} V</li>@endif
                @if ($product->capacity_wh)<li class="list-group-item">Capacité : {{ $product->capacity_wh }} Wh</li>@endif
                @if ($product->capacity_ah)<li class="list-group-item">Capacité : {{ $product->capacity_ah }} Ah</li>@endif
                @if ($product->surge_power_w)<li class="list-group-item">Pic : {{ $product->surge_power_w }} W</li>@endif
                <li class="list-group-item">Prix journalier : <strong>{{ tnd($product->daily_price) }}</strong></li>
                <li class="list-group-item">Caution : {{ tnd($product->deposit) }}</li>
                <li class="list-group-item">
                    @if ($product->isAvailable())
                        <span class="text-success">Disponible ({{ $product->quantity }})</span>
                    @else
                        <span class="text-danger">Indisponible</span>
                    @endif
                </li>
            </ul>
            <a class="btn btn-solar" href="{{ route('reservation.create', ['product' => $product->id]) }}">Réserver ce produit</a>
        </div>
    </div>
</div>
@endsection
