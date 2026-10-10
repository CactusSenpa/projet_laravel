@extends('layouts.admin')
@section('title', 'Réservation #'.$reservation->id)
@section('content')
<div class="bg-white p-4 rounded">
    <p><strong>{{ $reservation->customer_name }}</strong> — {{ $reservation->customer_phone }} — {{ $reservation->customer_email }}</p>
    @if ($reservation->pack)
        <p><strong>Pack :</strong> {{ $reservation->pack->name }}</p>
    @endif
    @if ($reservation->products->isNotEmpty())
        <p><strong>Matériel individuel réservé :</strong></p>
        <ul>
            @foreach ($reservation->products as $rp)
                <li>{{ $rp->quantity }} × {{ $rp->product?->name }} ({{ tnd($rp->product?->daily_price) }}/j • caution {{ tnd($rp->product?->deposit) }})</li>
            @endforeach
        </ul>
    @endif
    @if (! $reservation->pack && $reservation->products->isEmpty())
        <p class="text-muted"><em>Matériel : à confirmer avec l'équipe</em></p>
    @endif
    <p>Lieu : {{ $reservation->location }} @if($reservation->address)({{ $reservation->address }})@endif</p>
    <p>Du {{ $reservation->start_date->format('d/m/Y') }} au {{ $reservation->end_date->format('d/m/Y') }} ({{ $reservation->days() }} jour(s))</p>
    <p>Livraison : {{ $reservation->delivery_required ? 'oui ('.tnd($reservation->delivery_fee).')' : 'non' }}</p>
    <p>Total estimé {{ tnd($reservation->estimated_price) }} • Caution {{ tnd($reservation->deposit_amount) }}</p>
    <p>{{ $reservation->customer_message }}</p>
    <form method="post" action="{{ route('admin.reservations.status', $reservation) }}" class="d-flex gap-2">
        @csrf @method('PATCH')
        <select name="status" class="form-select w-auto">
            @foreach (\App\Models\Reservation::STATUSES as $status)
                <option value="{{ $status }}" @selected($reservation->status === $status)>{{ $status }}</option>
            @endforeach
        </select>
        <button class="btn btn-solar">Mettre à jour</button>
    </form>
</div>
@endsection
