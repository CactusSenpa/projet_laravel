@extends('layouts.app')

@section('title', 'Réinitialiser le mot de passe')

@section('content')
<div class="container py-5 col-md-5 col-lg-4">
    <h1 class="h3 mb-3">Réinitialiser le mot de passe</h1>
    @if ($errors->any())
        @include('components.alert', ['type' => 'danger', 'message' => $errors->first()])
    @endif
    <form method="post" action="{{ route('password.update') }}">
        @csrf
        <input type="hidden" name="token" value="{{ $token }}">
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="email" value="{{ old('email', $email) }}" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Nouveau mot de passe</label>
            <input class="form-control" type="password" name="password" required minlength="8">
        </div>
        <div class="mb-3">
            <label class="form-label">Confirmer le mot de passe</label>
            <input class="form-control" type="password" name="password_confirmation" required minlength="8">
        </div>
        <button class="btn btn-solar w-100">Réinitialiser</button>
    </form>
</div>
@endsection
