@extends('layouts.app')

@section('title', 'Mon profil')

@section('content')
<div class="container py-5 col-md-8 col-lg-6">
    <h1 class="h3 mb-4">Profile / More Information</h1>
    @if ($errors->any())
        @include('components.alert', ['type' => 'danger', 'message' => $errors->first()])
    @endif
    <form method="post" action="{{ route('client.profile.update') }}" enctype="multipart/form-data">
        @csrf
        @method('PUT')
        @if ($user->profile_photo)
            <img src="{{ asset('storage/'.$user->profile_photo) }}" alt="Photo de profil" class="rounded-circle mb-3" width="90" height="90">
        @endif
        <div class="mb-3"><label class="form-label">Photo de profil</label><input class="form-control" type="file" name="profile_photo" accept="image/*"></div>
        <div class="mb-3"><label class="form-label">Nom</label><input class="form-control" name="name" value="{{ old('name', $user->name) }}" required></div>
        <div class="mb-3"><label class="form-label">E-mail</label><input class="form-control" type="email" name="email" value="{{ old('email', $user->email) }}" required></div>
        <div class="mb-3"><label class="form-label">Téléphone</label><input class="form-control" name="phone" value="{{ old('phone', $user->phone) }}"></div>
        <button class="btn btn-solar">Enregistrer</button>
    </form>
</div>
@endsection
