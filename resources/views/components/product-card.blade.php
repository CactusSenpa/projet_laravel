@php
    $src = $product->image ? asset('storage/'.$product->image) : null;
@endphp
<div class="card h-100 card-product shadow-sm">
    @if ($src)
        <img src="{{ $src }}" alt="{{ $product->name }}">
    @else
        <div class="placeholder-visual"><i class="bi bi-lightning-charge-fill"></i></div>
    @endif
    <div class="card-body d-flex flex-column">
        <div class="d-flex justify-content-between align-items-start mb-2">
            <span class="badge text-bg-dark">{{ $product->category->name }}</span>
            @if ($product->isAvailable())
                <span class="badge text-bg-success">Disponible</span>
            @else
                <span class="badge text-bg-danger">Indisponible</span>
            @endif
        </div>
        <h3 class="h5">{{ $product->name }}</h3>
        <p class="small text-muted mb-1">Réf. {{ $product->reference }}</p>
        @if ($product->power_w)
            <p class="small mb-2">{{ $product->power_w }} W</p>
        @elseif ($product->capacity_wh)
            <p class="small mb-2">{{ $product->capacity_wh }} Wh</p>
        @endif
        <p class="fw-bold mb-3">{{ tnd($product->daily_price) }} / jour</p>
        <a href="{{ route('products.show', $product) }}" class="btn btn-outline-dark mt-auto">Voir détails</a>
    </div>
</div>
