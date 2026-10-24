@extends('layouts.admin')

@section('title', 'Modifier le client')

@section('content')
<h1 class="h3 mb-4">Modifier le client</h1>
@include('admin.clients.form', ['action' => route('admin.clients.update', $client), 'method' => 'PUT', 'client' => $client])
@endsection
