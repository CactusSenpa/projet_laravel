@extends('layouts.admin')

@section('title', 'Nouveau client')

@section('content')
<h1 class="h3 mb-4">Nouveau client</h1>
@include('admin.clients.form', ['action' => route('admin.clients.store'), 'method' => 'POST', 'client' => null])
@endsection
