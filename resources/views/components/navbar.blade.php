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
                @auth
                    @if (auth()->user()->isClient())
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle d-flex align-items-center gap-2" href="#" role="button" data-bs-toggle="dropdown">
                                @if (auth()->user()->profile_photo)
                                    <img src="{{ asset('storage/'.auth()->user()->profile_photo) }}" alt="" class="rounded-circle" width="32" height="32">
                                @else
                                    <i class="bi bi-person-circle fs-5"></i>
                                @endif
                                {{ auth()->user()->name }}
                            </a>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item" href="{{ route('client.profile') }}">Profile / More Information</a></li>
                                <li><a class="dropdown-item" href="{{ route('client.reservations') }}">Reservation History</a></li>
                                <li><hr class="dropdown-divider"></li>
                                <li><form method="post" action="{{ route('logout') }}">@csrf<button class="dropdown-item">Logout</button></form></li>
                            </ul>
                        </li>
                    @elseif (auth()->user()->isAdmin())
                        <li class="nav-item"><a class="btn btn-outline-light btn-sm" href="{{ route('admin.dashboard') }}">Administration</a></li>
                    @endif
                @else
                    <li class="nav-item"><a class="nav-link" href="{{ route('login') }}">Login</a></li>
                    <li class="nav-item"><a class="btn btn-solar btn-sm" href="{{ route('register') }}">Register</a></li>
                @endauth
            </ul>
        </div>
    </div>
</nav>
