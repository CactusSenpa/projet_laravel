<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Admin — {{ $companyName }}</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
<div class="d-flex">
    <aside class="admin-sidebar p-3" style="width: 240px">
        <a class="d-block fw-bold text-warning text-decoration-none mb-4" href="{{ route('admin.dashboard') }}">{{ $companyName }} Admin</a>
        @php
            $links = [
                ['admin.dashboard', 'Dashboard', 'speedometer2'],
                ['admin.products.index', 'Produits', 'box'],
                ['admin.packs.index', 'Packs', 'collection'],
                ['admin.reservations.index', 'Réservations', 'calendar-check'],
                ['admin.availability.index', 'Disponibilité', 'clock'],
                ['admin.appliances.index', 'Appareils', 'plug'],
                ['admin.settings.index', 'Paramètres', 'gear'],
            ];
        @endphp
        @foreach ($links as $link)
            <a class="d-block py-2 text-decoration-none {{ request()->routeIs($link[0]) ? 'active' : '' }}" href="{{ route($link[0]) }}">
                <i class="bi bi-{{ $link[2] }}"></i> {{ $link[1] }}
            </a>
        @endforeach
        <form method="post" action="{{ route('logout') }}" class="mt-4">
            @csrf
            <button class="btn btn-outline-warning btn-sm">Déconnexion</button>
        </form>
        <a class="d-block small mt-3 text-secondary" href="{{ route('home') }}">← Site public</a>
    </aside>
    <div class="flex-grow-1 bg-light">
        <div class="p-3 border-bottom bg-white"><strong>@yield('title', 'Administration')</strong></div>
        <div class="p-4">
            @if (session('success'))
                @include('components.alert', ['type' => 'success', 'message' => session('success')])
            @endif
            @yield('content')
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
