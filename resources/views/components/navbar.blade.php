<nav class="navbar navbar-expand-lg navbar-wattloc sticky-top">
    <div class="container">
        <a class="navbar-brand fw-bold" href="{{ route('home') }}">
            <i class="bi bi-sun-fill text-warning"></i> {{ $companyName }}
        </a>
        <button class="navbar-toggler bg-light" type="button" data-bs-toggle="collapse" data-bs-target="#mainNav">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="mainNav">
            <ul class="navbar-nav ms-auto align-items-lg-center gap-lg-2">
                <li class="nav-item"><a class="nav-link" href="{{ route('catalogue') }}">Catalogue</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('packs.index') }}">Packs</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('calculator.index') }}">Calculateur</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('reservation.create') }}">Réserver</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('faq') }}">FAQ</a></li>
                <li class="nav-item"><a class="nav-link" href="{{ route('contact') }}">Contact</a></li>
                <li class="nav-item">
                    <a class="btn btn-success btn-sm" href="{{ $whatsappUrl }}" target="_blank" rel="noopener">
                        <i class="bi bi-whatsapp"></i> WhatsApp
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>
