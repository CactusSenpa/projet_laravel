@extends('layouts.admin')
@section('title', 'Produits')
@section('content')
<a class="btn btn-solar mb-3" href="{{ route('admin.products.create') }}">Nouveau produit</a>
<table class="table bg-white">
    <thead><tr><th>Nom</th><th>Réf.</th><th>Prix / jour</th><th>Stock</th><th></th></tr></thead>
    <tbody>
    @foreach ($products as $product)
        <tr>
            <td>{{ $product->name }}</td>
            <td>{{ $product->reference }}</td>
            <td>{{ tnd($product->daily_price) }}</td>
            <td>{{ $product->quantity }}</td>
            <td>
                <a href="{{ route('admin.products.edit', $product) }}">Modifier</a>
                <form class="d-inline" method="post" action="{{ route('admin.products.destroy', $product) }}" onsubmit="return confirm('Supprimer ?')">
                    @csrf @method('DELETE')
                    <button class="btn btn-link text-danger p-0">Supprimer</button>
                </form>
            </td>
        </tr>
    @endforeach
    </tbody>
</table>
{{ $products->links() }}
@endsection
