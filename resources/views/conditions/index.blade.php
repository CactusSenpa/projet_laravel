@extends('layouts.app')

@section('title', 'Conditions de location')

@section('content')
<div class="container py-5 col-lg-8">
    <div class="alert alert-warning">Textes indicatifs à valider par l’entreprise. Ils ne constituent pas des conditions juridiques définitives.</div>
    <h1>Conditions de location</h1>
    @foreach ([
        'Caution' => 'Une caution est exigée à la remise. Elle n’est pas un paiement de la location.',
        'Retard' => 'Tout retard de restitution peut entraîner une journée supplémentaire facturée.',
        'Annulation' => 'Merci de prévenir dès que possible. Les règles d’annulation définitives seront précisées par l’entreprise.',
        'Casse' => 'Les dégradations constatées au retour peuvent être déduites de la caution.',
        'Perte' => 'Le matériel non restitué est facturé à sa valeur de remplacement.',
        'Utilisation incorrecte' => 'Le client utilise le matériel conformément aux consignes (charges, intempéries, branchements).',
        'Responsabilité du client' => 'Le client reste responsable du matériel pendant toute la période de location.',
        'Livraison' => 'La livraison est optionnelle. Les frais dépendent de la zone (Grand Tunis, Sousse, Sfax, etc.).',
        'Retour du matériel' => 'Le matériel doit être rendu propre, complet et dans l’état de départ, hors usure normale.',
    ] as $title => $text)
        <h2 class="h5 mt-4">{{ $title }}</h2>
        <p>{{ $text }}</p>
    @endforeach
</div>
@endsection
