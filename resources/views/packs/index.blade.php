@extends('layouts.app')

@section('title', 'Packs énergétiques à louer')

@section('content')
<div class="container py-5">
    <h1 class="mb-4">Packs prêts à louer</h1>
    <div class="row g-4">
        @foreach ($packs as $pack)
            <div class="col-md-4">
                @include('components.pack-card', ['pack' => $pack])
            </div>
        @endforeach
    </div>
</div>
@endsection
