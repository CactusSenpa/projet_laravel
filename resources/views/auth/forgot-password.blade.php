@extends('layouts.app')

@section('title', 'Mot de passe oublié')

@section('content')
<div class="container py-5 col-md-5 col-lg-4">
    <h1 class="h3 mb-3">Mot de passe oublié</h1>
    <p class="text-muted">Saisissez votre e-mail pour recevoir un lien de réinitialisation.</p>
    @if ($errors->any())
        @include('components.alert', ['type' => 'danger', 'message' => $errors->first()])
    @endif
    @if (session('status'))
        <div class="alert alert-success">{{ session('status') }}</div>
    @endif
    <form method="post" action="{{ route('password.email') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="email" value="{{ old('email') }}" required autofocus>
        </div>
        <button class="btn btn-solar w-100">Envoyer le lien</button>
    </form>
    <p class="small mt-3"><a href="{{ route('login') }}">Retour à la connexion</a></p>
</div>
@endsection
