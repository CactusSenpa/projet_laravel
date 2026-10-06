@extends('layouts.app')

@section('title', 'Connexion admin')

@section('content')
<div class="container py-5 col-md-4">
    <h1 class="h3 mb-3">Administration</h1>
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
</div>
@endsection
