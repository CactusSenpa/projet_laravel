@extends('layouts.app')

@section('title', 'Vérifier votre e-mail')

@section('content')
<div class="container py-5 col-md-6 col-lg-5">
    <h1 class="h3 mb-3">Vérifiez votre adresse e-mail</h1>
    <p>Un lien de vérification a été envoyé à <strong>{{ auth()->user()->email }}</strong>.</p>
    <p class="text-muted">Cliquez sur ce lien dans votre e-mail pour activer votre compte client.</p>
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <form method="post" action="{{ route('verification.send') }}">
        @csrf
        <button class="btn btn-solar">Renvoyer l’e-mail</button>
    </form>
    <form method="post" action="{{ route('logout') }}" class="mt-3">
        @csrf
        <button class="btn btn-link px-0">Se déconnecter</button>
    </form>
</div>
@endsection
