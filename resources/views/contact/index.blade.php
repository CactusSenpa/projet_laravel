@extends('layouts.app')

@section('title', 'Contact')

@section('content')
<div class="container py-5 col-lg-6">
    <h1>Contact</h1>
    <p>Décrivez votre projet et envoyez-nous votre message.</p>

    @if (session('status'))
        <div class="alert alert-success" role="alert">
            {{ session('status') }}
        </div>
    @endif

    <form method="post" action="{{ route('contact.send') }}">
        @csrf
        <div class="mb-3">
            <label class="form-label">Nom</label>
            <input class="form-control" name="name" required>
        </div>
        <div class="mb-3">
            <label class="form-label">Téléphone</label>
            <input class="form-control" name="phone" required>
        </div>
        <div class="mb-3">
            <label class="form-label">E-mail</label>
            <input class="form-control" type="email" name="email">
        </div>
        <div class="mb-3">
            <label class="form-label">Message</label>
            <textarea class="form-control" name="message" rows="4" required></textarea>
        </div>
        <button class="btn btn-solar">Envoyer le message</button>
    </form>
</div>
@endsection
