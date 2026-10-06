<footer class="site-footer mt-5 py-5">
    <div class="container">
        <div class="row g-4">
            <div class="col-md-4">
                <h5 class="text-warning">{{ $companyName }}</h5>
                <p class="mb-1">Location temporaire d’énergie en Tunisie.</p>
                <p class="small text-secondary mb-0">Prix affichés en TND. Interface en français.</p>
            </div>
            <div class="col-md-4">
                <h6>Liens</h6>
                <ul class="list-unstyled">
                    <li><a class="link-light text-decoration-none" href="{{ route('calculator.index') }}">Calculateur</a></li>
                    <li><a class="link-light text-decoration-none" href="{{ route('packs.index') }}">Packs</a></li>
                    <li><a class="link-light text-decoration-none" href="{{ route('conditions') }}">Conditions</a></li>
                    <li><a class="link-light text-decoration-none" href="{{ route('faq') }}">FAQ</a></li>
                </ul>
            </div>
            <div class="col-md-4">
                <h6>Contact</h6>
                <a class="btn btn-success" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">
                    <i class="bi bi-whatsapp"></i> Écrire sur WhatsApp
                </a>
            </div>
        </div>
    </div>
</footer>
