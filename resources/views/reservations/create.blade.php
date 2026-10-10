@extends('layouts.app')

@section('title', 'Demande de réservation')

@section('content')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

<div class="container py-5">
    <div class="row justify-content-center">
        <div class="col-lg-10">
            <h1 class="h2 mb-2">Demande de réservation</h1>
            <p class="text-muted mb-4">Aucun paiement en ligne immédiat : notre équipe valide la disponibilité avec vous via WhatsApp.</p>

            @if ($errors->any())
                <div class="alert alert-danger mb-4">
                    <ul class="mb-0">@foreach ($errors->all() as $error)<li>{{ $error }}</li>@endforeach</ul>
                </div>
            @endif

            @if ($selectedProduct)
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4">
                    <i class="bi bi-box-seam-fill fs-3 me-3 text-warning"></i>
                    <div>
                        <div class="fw-semibold">Matériel sélectionné : {{ $selectedProduct->name }}</div>
                        <div class="small text-muted">
                            Prix : <strong>{{ tnd($selectedProduct->daily_price) }}/jour</strong> • Caution : <strong>{{ tnd($selectedProduct->deposit) }}</strong> • Réf : {{ $selectedProduct->reference }}
                        </div>
                    </div>
                </div>
            @elseif ($pack)
                <div class="alert alert-warning border-0 shadow-sm d-flex align-items-center mb-4">
                    <i class="bi bi-boxes fs-3 me-3 text-warning"></i>
                    <div>
                        <div class="fw-semibold">Pack sélectionné : {{ $pack->name }}</div>
                        <div class="small text-muted">
                            Prix : <strong>{{ tnd($pack->price_per_day) }}/jour</strong> • Caution : <strong>{{ tnd($pack->deposit) }}</strong>
                        </div>
                    </div>
                </div>
            @endif

            <form method="post" action="{{ route('reservation.store') }}" id="reservation-form" class="row g-3">
                @csrf
                @if ($quote)
                    <input type="hidden" name="quote_id" value="{{ $quote->id }}">
                    <input type="hidden" name="project_type" value="{{ $quote->project_type }}">
                @endif

                <div class="col-12">
                    <div class="card border-0 shadow-sm mb-2">
                        <div class="card-body">
                            <h2 class="h5 mb-3"><i class="bi bi-cart-check me-2 text-warning"></i>Matériel ou Pack souhaité</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Pack complet</label>
                                    <select name="pack_id" id="pack_id" class="form-select">
                                        <option value="" data-price="0" data-deposit="0">-- Aucun (Réservation de matériel à l'unité) --</option>
                                        @foreach ($packs as $item)
                                            <option value="{{ $item->id }}"
                                                data-price="{{ $item->price_per_day }}"
                                                data-deposit="{{ $item->deposit }}"
                                                @selected(($pack->id ?? old('pack_id')) == $item->id)>
                                                {{ $item->name }} — {{ tnd($item->price_per_day) }}/j (caution {{ tnd($item->deposit) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Idéal pour les solutions prêtes à l'emploi.</div>
                                </div>

                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">OU Produit unitaire</label>
                                    <select name="product_id" id="product_id" class="form-select">
                                        <option value="" data-price="0" data-deposit="0">-- Aucun produit --</option>
                                        @foreach ($products as $item)
                                            <option value="{{ $item->id }}"
                                                data-price="{{ $item->daily_price }}"
                                                data-deposit="{{ $item->deposit }}"
                                                @selected(($selectedProduct->id ?? old('product_id')) == $item->id)>
                                                {{ $item->name }} — {{ tnd($item->daily_price) }}/j (caution {{ tnd($item->deposit) }})
                                            </option>
                                        @endforeach
                                    </select>
                                    <div class="form-text">Batteries, panneaux, onduleurs, etc.</div>
                                </div>

                                <div class="col-md-2">
                                    <label class="form-label fw-semibold">Quantité</label>
                                    <input class="form-control" type="number" min="1" max="50" name="product_quantity" id="product_quantity" value="{{ old('product_quantity', 1) }}">
                                    <div class="form-text">Si produit unitaire.</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm mb-2">
                        <div class="card-body">
                            <h2 class="h5 mb-3"><i class="bi bi-person-lines-fill me-2 text-warning"></i>Vos coordonnées</h2>
                            <div class="row g-3">
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Nom complet *</label>
                                    <input class="form-control" name="customer_name" value="{{ old('customer_name') }}" placeholder="Ex: Bacem Mansour" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Téléphone *</label>
                                    <input class="form-control" name="customer_phone" value="{{ old('customer_phone') }}" placeholder="Ex: 53663608" required>
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">E-mail</label>
                                    <input class="form-control" type="email" name="customer_email" value="{{ old('customer_email') }}" placeholder="contact@exemple.tn">
                                </div>
                                <div class="col-md-6">
                                    <label class="form-label fw-semibold">Numéro CIN <span class="text-muted fw-normal">(optionnel)</span></label>
                                    <input class="form-control" name="cin" value="{{ old('cin') }}" placeholder="Ex: 08123456">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 shadow-sm mb-2">
                        <div class="card-body">
                            <h2 class="h5 mb-3"><i class="bi bi-calendar-event me-2 text-warning"></i>Période et lieu</h2>
                            <div class="row g-3">
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Date de début *</label>
                                    <input class="form-control bg-white" type="text" name="start_date" id="start_date" value="{{ old('start_date', now()->toDateString()) }}" placeholder="Sélectionnez la date" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Date de fin *</label>
                                    <input class="form-control bg-white" type="text" name="end_date" id="end_date" value="{{ old('end_date', now()->addDay()->toDateString()) }}" placeholder="Sélectionnez la date" required>
                                </div>
                                <div class="col-md-4">
                                    <label class="form-label fw-semibold">Gouvernorat *</label>
                                    <select name="location" class="form-select" required>
                                        @foreach ($governorates as $gov)
                                            <option value="{{ $gov }}" @selected(old('location', 'Tunis') === $gov)>{{ $gov }}</option>
                                        @endforeach
                                    </select>
                                </div>

                                <div class="col-12" id="stock-notice-wrapper">
                                    <div id="availability-notice" class="alert alert-danger d-none py-2 px-3 small mb-0">
                                        <i class="bi bi-calendar-x-fill text-danger me-1"></i>
                                        <span id="availability-notice-text"></span>
                                    </div>
                                    <div id="disabled-dates-info" class="alert alert-info py-2 px-3 small mb-0 d-none">
                                        <i class="bi bi-info-circle-fill me-1"></i>
                                        Certaines dates sont grisées dans le calendrier car le matériel est déjà réservé par des clients confirmés.
                                    </div>
                                </div>

                                <div class="col-12">
                                    <label class="form-label fw-semibold">Adresse exacte</label>
                                    <input class="form-control" name="address" value="{{ old('address') }}" placeholder="Rue, ville, indications pour la livraison ou le retrait">
                                </div>
                                <div class="col-12">
                                    <div class="form-check">
                                        <input class="form-check-input" type="checkbox" name="delivery_required" id="delivery_required" value="1" data-fee="{{ setting('delivery_fee', 30) }}" @checked(old('delivery_required'))>
                                        <label class="form-check-label fw-semibold" for="delivery_required">
                                            Livraison sur site souhaitée (frais indicatifs : {{ tnd(setting('delivery_fee', 30)) }})
                                        </label>
                                    </div>
                                </div>
                                <div class="col-12">
                                    <label class="form-label fw-semibold">Message / Précisions</label>
                                    <textarea class="form-control" name="customer_message" rows="2" placeholder="Précisez ici toute contrainte technique ou horaire">{{ old('customer_message') }}</textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-12">
                    <div class="card border-0 bg-dark text-white p-3 shadow-sm">
                        <div class="d-flex flex-wrap justify-content-between align-items-center gap-3">
                            <div>
                                <div class="small text-uppercase text-white-50">Estimation récapitulative (<span id="preview-days">1</span> jour<span id="preview-days-s"></span>)</div>
                                <div class="h3 mb-0 text-warning">
                                    Total estimé : <span id="preview-price">0,00</span> TND
                                </div>
                                <div class="small text-white-50">
                                    Caution estimée : <strong class="text-white" id="preview-deposit">0,00</strong> TND
                                </div>
                            </div>
                            <button class="btn btn-solar btn-lg px-4" id="submit-btn" type="submit">
                                Envoyer la demande <i class="bi bi-arrow-right ms-1"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
<script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/fr.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function () {
    const packSelect = document.getElementById('pack_id');
    const productSelect = document.getElementById('product_id');
    const quantityInput = document.getElementById('product_quantity');
    const startDateInput = document.getElementById('start_date');
    const endDateInput = document.getElementById('end_date');
    const deliveryCheckbox = document.getElementById('delivery_required');
    const submitBtn = document.getElementById('submit-btn');

    const previewDays = document.getElementById('preview-days');
    const previewDaysS = document.getElementById('preview-days-s');
    const previewPrice = document.getElementById('preview-price');
    const previewDeposit = document.getElementById('preview-deposit');

    const availabilityNotice = document.getElementById('availability-notice');
    const availabilityNoticeText = document.getElementById('availability-notice-text');
    const disabledDatesInfo = document.getElementById('disabled-dates-info');

    let unavailableDates = @json($initialUnavailableDates ?? []);

    function hasDisabledDateInRange(startStr, endStr) {
        if (!startStr || !endStr || unavailableDates.length === 0) return false;
        let curr = new Date(startStr);
        const end = new Date(endStr);
        if (isNaN(curr.getTime()) || isNaN(end.getTime()) || end < curr) return false;

        while (curr <= end) {
            const year = curr.getFullYear();
            const month = String(curr.getMonth() + 1).padStart(2, '0');
            const day = String(curr.getDate()).padStart(2, '0');
            const ymd = `${year}-${month}-${day}`;

            if (unavailableDates.includes(ymd)) {
                return true;
            }
            curr.setDate(curr.getDate() + 1);
        }
        return false;
    }

    function checkRangeAvailability() {
        const startVal = startDateInput.value;
        const endVal = endDateInput.value;

        if (unavailableDates.length > 0) {
            disabledDatesInfo.classList.remove('d-none');
        } else {
            disabledDatesInfo.classList.add('d-none');
        }

        if (hasDisabledDateInRange(startVal, endVal)) {
            availabilityNoticeText.textContent = "La période sélectionnée chevauche des dates où ce matériel est en rupture de stock (déjà réservé). Veuillez choisir d'autres dates.";
            availabilityNotice.classList.remove('d-none');
            submitBtn.disabled = true;
            submitBtn.classList.add('opacity-50');
            return false;
        } else {
            availabilityNotice.classList.add('d-none');
            submitBtn.disabled = false;
            submitBtn.classList.remove('opacity-50');
            return true;
        }
    }

    const startPicker = flatpickr(startDateInput, {
        locale: 'fr',
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd/m/Y',
        minDate: 'today',
        disable: unavailableDates,
        onChange: function (selectedDates, dateStr) {
            if (selectedDates.length > 0) {
                endPicker.set('minDate', dateStr);
                if (endDateInput.value && new Date(endDateInput.value) < selectedDates[0]) {
                    endPicker.setDate(dateStr);
                }
            }
            checkRangeAvailability();
            updatePreview();
        }
    });

    const endPicker = flatpickr(endDateInput, {
        locale: 'fr',
        dateFormat: 'Y-m-d',
        altInput: true,
        altFormat: 'd/m/Y',
        minDate: startDateInput.value || 'today',
        disable: unavailableDates,
        onChange: function () {
            checkRangeAvailability();
            updatePreview();
        }
    });

    function calculateDays() {
        if (!startDateInput.value || !endDateInput.value) return 1;
        const start = new Date(startDateInput.value);
        const end = new Date(endDateInput.value);
        if (isNaN(start) || isNaN(end) || end < start) return 1;
        const diffMs = end - start;
        const diffDays = Math.round(diffMs / (1000 * 60 * 60 * 24)) + 1;
        return Math.max(1, diffDays);
    }

    function formatNumber(num) {
        return num.toLocaleString('fr-FR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
    }

    function updatePreview() {
        const days = calculateDays();
        previewDays.textContent = days;
        previewDaysS.textContent = days > 1 ? 's' : '';

        const packOption = packSelect.options[packSelect.selectedIndex];
        const packPrice = parseFloat(packOption ? packOption.dataset.price || 0 : 0);
        const packDeposit = parseFloat(packOption ? packOption.dataset.deposit || 0 : 0);

        const prodOption = productSelect.options[productSelect.selectedIndex];
        const prodPrice = parseFloat(prodOption ? prodOption.dataset.price || 0 : 0);
        const prodDeposit = parseFloat(prodOption ? prodOption.dataset.deposit || 0 : 0);
        const quantity = Math.max(1, parseInt(quantityInput.value || 1, 10));

        const deliveryFee = deliveryCheckbox.checked ? parseFloat(deliveryCheckbox.dataset.fee || 30) : 0;

        const dailyTotal = packPrice + (prodPrice * quantity);
        const totalDeposit = packDeposit + (prodDeposit * quantity);
        const totalPrice = (dailyTotal * days) + deliveryFee;

        previewPrice.textContent = formatNumber(totalPrice);
        previewDeposit.textContent = formatNumber(totalDeposit);
    }

    function reloadUnavailableDates() {
        const packId = packSelect.value;
        const productId = productSelect.value;
        const qty = quantityInput.value || 1;

        if (!packId && !productId) {
            unavailableDates = [];
            startPicker.set('disable', []);
            endPicker.set('disable', []);
            checkRangeAvailability();
            return;
        }

        const url = new URL("{{ route('reservation.unavailable-dates') }}", window.location.origin);
        if (productId) {
            url.searchParams.set('product_id', productId);
            url.searchParams.set('quantity', qty);
        } else if (packId) {
            url.searchParams.set('pack_id', packId);
        }

        fetch(url)
            .then(res => res.json())
            .then(data => {
                unavailableDates = data.unavailable_dates || [];
                startPicker.set('disable', unavailableDates);
                endPicker.set('disable', unavailableDates);
                checkRangeAvailability();
                updatePreview();
            })
            .catch(err => {
                console.error("Erreur de chargement des disponibilités:", err);
            });
    }

    packSelect.addEventListener('change', function () {
        if (this.value && productSelect.value) {
            productSelect.value = '';
        }
        reloadUnavailableDates();
        updatePreview();
    });

    productSelect.addEventListener('change', function () {
        if (this.value && packSelect.value) {
            packSelect.value = '';
        }
        reloadUnavailableDates();
        updatePreview();
    });

    quantityInput.addEventListener('input', function () {
        reloadUnavailableDates();
        updatePreview();
    });

    deliveryCheckbox.addEventListener('change', updatePreview);

    checkRangeAvailability();
    updatePreview();
});
</script>
@endpush
