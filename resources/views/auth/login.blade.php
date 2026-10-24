@extends('layouts.app')

@section('title', 'Connexion')

@section('content')
<div class="container py-5 col-md-4">
    <h1 class="h3 mb-3">Connexion</h1>
    @if ($errors->any())
        @include('components.alert', ['type' => 'danger', 'message' => $errors->first()])
    @endif
    <form method="post" action="{{ route('login') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Mot de passe</label>
            <input class="form-control" type="password" name="password" required>
        </div>
        <button class="btn btn-solar w-100">Connexion</button>
    </form>
    @if (session('status'))
        <div class="alert alert-success mt-3">{{ session('status') }}</div>
    @endif
    <p class="small mt-3"><a href="{{ route('password.request') }}">Mot de passe oublié ?</a></p>
    <p class="small text-muted mt-3">Pas encore de compte client ? <a href="{{ route('register') }}">Créer un compte</a></p>
</div>
@endsection
