@extends('layouts.app')

@section('title', $pack->name)

@section('content')
<div class="container py-5">
    <div class="row g-4">
        <div class="col-lg-7">
            <h1>{{ $pack->name }}</h1>
            <p>{{ $pack->description }}</p>
            <p><strong>Énergie disponible :</strong> {{ $pack->energy_capacity_wh }} Wh</p>
            <p><strong>Puissance continue :</strong> {{ $pack->continuous_power_w }} W
                @if ($pack->surge_power_w) • pic {{ $pack->surge_power_w }} W @endif
            </p>
            <p><strong>Prix :</strong> {{ tnd($pack->price_per_day) }} / jour • Caution {{ tnd($pack->deposit) }}</p>
            @if ($pack->recommended_uses)
                <p>Usages : {{ implode(', ', $pack->recommended_uses) }}</p>
            @endif
            <h2 class="h5 mt-4">Contenu</h2>
            <ul>
                @foreach ($pack->products as $product)
                    <li>{{ $product->pivot->quantity }} × {{ $product->name }}</li>
                @endforeach
            </ul>
            <a class="btn btn-solar" href="{{ route('reservation.create', ['pack' => $pack->id]) }}">Réserver ce pack</a>
            <a class="btn btn-outline-dark" href="{{ route('calculator.index') }}">Vérifier mes besoins</a>
        </div>
    </div>
</div>
@endsection
