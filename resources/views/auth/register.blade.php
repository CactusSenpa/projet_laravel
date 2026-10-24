@extends('layouts.app')

@section('title', 'Créer un compte')

@section('content')
<div class="container py-5 col-md-6 col-lg-5">
    <h1 class="h3 mb-3">Créer un compte client</h1>
    @if ($errors->any())
        @include('components.alert', ['type' => 'danger', 'message' => $errors->first()])
    @endif
    <form method="post" action="{{ route('register') }}">
        @csrf
        <div class="mb-3"><label class="form-label">Nom complet</label><input class="form-control" name="name" value="{{ old('name') }}" required></div>
        <div class="mb-3"><label class="form-label">E-mail</label><input class="form-control" type="email" name="email" value="{{ old('email') }}" required></div>
        <div class="mb-3"><label class="form-label">Téléphone</label><input class="form-control" name="phone" value="{{ old('phone') }}"></div>
        <div class="mb-3"><label class="form-label">Mot de passe</label><input class="form-control" type="password" name="password" required minlength="8"></div>
        <div class="mb-3"><label class="form-label">Confirmer le mot de passe</label><input class="form-control" type="password" name="password_confirmation" required minlength="8"></div>
        <button class="btn btn-solar w-100">Créer mon compte</button>
    </form>
</div>
@endsection
