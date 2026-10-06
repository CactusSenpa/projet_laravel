@extends('layouts.admin')
@section('title', 'Packs')
@section('content')
<a class="btn btn-solar mb-3" href="{{ route('admin.packs.create') }}">Nouveau pack</a>
<table class="table bg-white">
    <thead><tr><th>Nom</th><th>Prix / jour</th><th>Wh</th><th>Produits</th><th></th></tr></thead>
    <tbody>
    @foreach ($packs as $pack)
        <tr>
            <td>{{ $pack->name }}</td>
            <td>{{ tnd($pack->price_per_day) }}</td>
            <td>{{ $pack->energy_capacity_wh }}</td>
            <td>{{ $pack->products_count }}</td>
            <td>
                <a href="{{ route('admin.packs.edit', $pack) }}">Modifier</a>
                <form class="d-inline" method="post" action="{{ route('admin.packs.destroy', $pack) }}" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-link text-danger p-0">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $packs->links() }}
@endsection
