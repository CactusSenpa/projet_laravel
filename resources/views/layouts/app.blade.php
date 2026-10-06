<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Location d’énergie temporaire') — {{ $companyName }}</title>
    <meta name="description" content="@yield('meta_description', 'Location de panneaux solaires, batteries, onduleurs et packs énergétiques en Tunisie. Calculez vos besoins et réservez en TND.')">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    @include('components.navbar')

    <main>
        @if (session('success'))
            <div class="container pt-3">
                @include('components.alert', ['type' => 'success', 'message' => session('success')])
            </div>
        @endif
        @yield('content')
    </main>

    @include('components.footer')

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    @stack('scripts')
</body>
</html>
