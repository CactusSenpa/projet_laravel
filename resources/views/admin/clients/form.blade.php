@if ($errors->any())
    @include('components.alert', ['type' => 'danger', 'message' => $errors->first()])
@endif
<form method="post" action="{{ $action }}" class="bg-white p-4 rounded shadow-sm col-lg-7">
    @csrf
    @if ($method !== 'POST') @method($method) @endif
    <div class="mb-3"><label class="form-label">Nom</label><input class="form-control" name="name" value="{{ old('name', $client?->name) }}" required></div>
    <div class="mb-3"><label class="form-label">E-mail</label><input class="form-control" type="email" name="email" value="{{ old('email', $client?->email) }}" required></div>
    <div class="mb-3"><label class="form-label">Téléphone</label><input class="form-control" name="phone" value="{{ old('phone', $client?->phone) }}"></div>
    <div class="mb-3"><label class="form-label">Mot de passe {{ $client ? '(laisser vide pour conserver)' : '' }}</label><input class="form-control" type="password" name="password" {{ $client ? '' : 'required' }} minlength="8"></div>
    <div class="mb-3"><label class="form-label">Confirmation du mot de passe</label><input class="form-control" type="password" name="password_confirmation" {{ $client ? '' : 'required' }} minlength="8"></div>
    @if ($client)
        <div class="form-check mb-3"><input class="form-check-input" type="checkbox" name="is_active" value="1" id="is_active" @checked(old('is_active', $client->is_active))><label class="form-check-label" for="is_active">Compte actif</label></div>
    @endif
    <button class="btn btn-solar">Enregistrer</button>
    <a class="btn btn-link" href="{{ route('admin.clients.index') }}">Annuler</a>
</form>
