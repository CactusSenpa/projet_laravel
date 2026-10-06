@php
    $src = $pack->image ? asset('storage/'.$pack->image) : null;
@endphp
<div class="card h-100 shadow-sm">
    @if ($src)
        <img src="{{ $src }}" class="pack-cover" alt="{{ $pack->name }}">
    @else
        <div class="placeholder-visual"><i class="bi bi-box-seam"></i></div>
    @endif
    <div class="card-body d-flex flex-column">
        <h3 class="h5">{{ $pack->name }}</h3>
        <p class="small text-muted">{{ \Illuminate\Support\Str::limit($pack->description, 110) }}</p>
        <p class="mb-1"><strong>{{ number_format($pack->energy_capacity_wh / 1000, 1, ',', ' ') }} kWh</strong> utiles • {{ $pack->continuous_power_w }} W</p>
        <p class="fw-bold">{{ tnd($pack->price_per_day) }} / jour</p>
        <a href="{{ route('packs.show', $pack) }}" class="btn btn-solar mt-auto">Voir le pack</a>
    </div>
</div>
