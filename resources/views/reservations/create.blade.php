@extends('layouts.app')

@section('title', 'Demande de réservation')

@section('content')
<div class="container py-5">
    <h1>Demande de réservation</h1>
    <p>Aucun paiement en ligne pour le MVP : nous confirmons ensuite par WhatsApp.</p>

    @if ($errors->any())
        <div class="alert alert-danger">
            <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
        </div>
    @endif

    <form method="post" action="{{ route('reservation.store') }}" class="row g-3">
        @csrf
        <div class="col-md-6">
            <label class="form-label">Pack</label>
            <select name="pack_id" class="form-select">
                <option value="">À confirmer avec l’équipe</option>
                @foreach ($packs as $item)
                    <option value="{{ $item->id }}" @selected(($pack->id ?? old('pack_id')) == $item->id)>{{ $item->name }} — {{ tnd($item->price_per_day) }}/jour</option>
                @endforeach
            </select>
        </div>
        @if ($quote)
            <input type="hidden" name="quote_id" value="{{ $quote->id }}">
            <input type="hidden" name="project_type" value="{{ $quote->project_type }}">
        @endif
        <div class="col-md-6">
            <label class="form-label">Nom *</label>
            <input class="form-control" name="customer_name" value="{{ old('customer_name') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Téléphone *</label>
            <input class="form-control" name="customer_phone" value="{{ old('customer_phone') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="customer_email" value="{{ old('customer_email') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">CIN</label>
            <input class="form-control" name="cin" value="{{ old('cin') }}">
        </div>
        <div class="col-md-4">
            <label class="form-label">Début *</label>
            <input class="form-control" type="date" name="start_date" value="{{ old('start_date') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Fin *</label>
            <input class="form-control" type="date" name="end_date" value="{{ old('end_date') }}" required>
        </div>
        <div class="col-md-4">
            <label class="form-label">Gouvernorat *</label>
            <select name="location" class="form-select" required>
                @foreach ($governorates as $gov)
                    <option value="{{ $gov }}" @selected(old('location') === $gov)>{{ $gov }}</option>
                @endforeach
            </select>
        </div>
        <div class="col-12">
            <label class="form-label">Adresse</label>
            <input class="form-control" name="address" value="{{ old('address') }}">
        </div>
        <div class="col-12">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" name="delivery_required" value="1" @checked(old('delivery_required'))>
                <label class="form-check-label">Livraison souhaitée (frais indicatifs {{ tnd(setting('delivery_fee', 30)) }})</label>
            </div>
        </div>
        <div class="col-12">
            <label class="form-label">Message</label>
            <textarea class="form-control" name="customer_message" rows="3">{{ old('customer_message') }}</textarea>
        </div>
        <div class="col-12">
            <button class="btn btn-solar">Envoyer la demande</button>
        </div>
    </form>
</div>
@endsection
