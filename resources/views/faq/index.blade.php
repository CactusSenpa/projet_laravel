@extends('layouts.app')

@section('title', 'FAQ')

@section('content')
<div class="container py-5 col-lg-8">
    <h1 class="mb-4">Questions fréquentes</h1>
    <div class="accordion" id="faq">
        @php
            $items = [
                ['Combien coûte la location ?', 'Les prix sont indiqués en TND par jour sur chaque fiche produit ou pack. Un devis est confirmé selon les dates et la livraison.'],
                ['Comment fonctionne la caution ?', 'Une caution est demandée à la remise du matériel et restituée après contrôle au retour, hors casse ou perte.'],
                ['Livrez-vous ?', 'Oui, principalement Grand Tunis et gouvernorats proches. Les frais sont indiqués à la réservation et restent configurables.'],
                ['Puis-je louer uniquement une batterie ?', 'Oui, le catalogue permet de louer des produits à l’unité ou un pack complet.'],
                ['Combien de temps faut-il pour installer le système ?', 'Un pack stand se met en place en général en moins d’une heure. Un pack chantier peut demander un peu plus selon le site.'],
                ['Puis-je utiliser une perceuse ?', 'Oui, à condition que l’onduleur couvre le pic de démarrage. Utilisez le calculateur et cochez « pic de démarrage ».'],
                ['Que se passe-t-il si mon besoin dépasse la capacité prévue ?', 'Nous proposons un pack supérieur, un générateur d’appoint, ou un échange après contact WhatsApp.'],
                ['Puis-je réserver plusieurs jours ?', 'Oui. Le prix estimé multiplie le tarif journalier par le nombre de jours inclus.'],
                ['Comment fonctionne la réservation ?', 'Vous envoyez une demande, nous confirmons la disponibilité, puis nous finalisons par WhatsApp. Pas de paiement en ligne dans cette version.'],
            ];
        @endphp
        @foreach ($items as $i => $faq)
            <div class="accordion-item">
                <h2 class="accordion-header">
                    <button class="accordion-button {{ $i ? 'collapsed' : '' }}" type="button" data-bs-toggle="collapse" data-bs-target="#faq{{ $i }}">
                        {{ $faq[0] }}
                    </button>
                </h2>
                <div id="faq{{ $i }}" class="accordion-collapse collapse {{ $i ? '' : 'show' }}" data-bs-parent="#faq">
                    <div class="accordion-body">{{ $faq[1] }}</div>
                </div>
            </div>
        @endforeach
    </div>
</div>
@endsection
