@extends('layouts.app')

@section('title', 'Demande envoyée')

@section('content')
<div class="container py-5 col-lg-7">
    <div class="card shadow-sm border-0">
        <div class="card-body p-4 p-md-5">
            <div class="d-flex align-items-center mb-3">
                <i class="bi bi-check-circle-fill text-success fs-1 me-3"></i>
                <div>
                    <h1 class="h3 mb-1">Demande n°{{ $reservation->id }} enregistrée</h1>
                    <p class="text-muted mb-0">Merci {{ $reservation->customer_name }}. Notre équipe vous confirme la disponibilité sous peu.</p>
                </div>
            </div>

            <div class="bg-light p-3 rounded mb-4">
                <ul class="list-unstyled mb-0">
                    @if ($reservation->pack)
                        <li class="mb-2">
                            <strong>Pack réservé :</strong> {{ $reservation->pack->name }}
                        </li>
                    @endif

                    @if ($reservation->products->isNotEmpty())
                        <li class="mb-2">
                            <strong>Matériel réservé :</strong>
                            @foreach ($reservation->products as $rp)
                                <span class="badge text-bg-dark me-1">
                                    {{ $rp->quantity }} × {{ $rp->product?->name }}
                                </span>
                            @endforeach
                        </li>
                    @endif

                    @if (! $reservation->pack && $reservation->products->isEmpty())
                        <li class="mb-2 text-muted">
                            <strong>Matériel :</strong> À confirmer avec l’équipe
                        </li>
                    @endif

                    <li class="mb-2">
                        <strong>Dates :</strong> {{ $reservation->start_date->format('d/m/Y') }} → {{ $reservation->end_date->format('d/m/Y') }}
                        <span class="text-muted">({{ $reservation->days() }} jour{{ $reservation->days() > 1 ? 's' : '' }})</span>
                    </li>
                    <li class="mb-2">
                        <strong>Lieu :</strong> {{ $reservation->location }} @if($reservation->address)({{ $reservation->address }})@endif
                    </li>
                    @if ($reservation->delivery_required)
                        <li class="mb-2">
                            <strong>Livraison :</strong> Demandée (+{{ tnd($reservation->delivery_fee) }})
                        </li>
                    @endif
                    <li class="mb-2">
                        <strong>Total estimé :</strong> <span class="fw-bold text-dark fs-5">{{ tnd($reservation->estimated_price) }}</span>
                    </li>
                    <li>
                        <strong>Caution :</strong> <span class="fw-bold text-secondary">{{ tnd($reservation->deposit_amount) }}</span>
                    </li>
                </ul>
            </div>

            <a class="btn btn-success btn-lg w-100 py-3" href="{{ $whatsappMessageUrl }}" target="_blank" rel="noopener">
                <i class="bi bi-whatsapp me-2"></i> Continuer sur WhatsApp
            </a>
            <div class="text-center mt-3">
                <a href="{{ route('home') }}" class="text-decoration-none text-muted small">← Retour à l’accueil</a>
            </div>
        </div>
    </div>
</div>
@endsection
