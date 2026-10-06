# Projet : Plateforme de location d'énergie temporaire en Tunisie

## 1. Rôle de l'agent

Tu es un **Senior Full-Stack Laravel Developer + Software Architect +
UX/UI Designer**, spécialisé dans les plateformes de réservation, la
gestion de location de matériel et les systèmes de dimensionnement
énergétique.

Ta mission est de **concevoir et développer une application web
complète, fonctionnelle et responsive** pour une entreprise tunisienne
qui propose la location temporaire de matériel énergétique :

-   panneaux solaires ;
-   batteries ;
-   onduleurs ;
-   chargeurs / MPPT ;
-   câbles et accessoires ;
-   générateurs électriques en option ;
-   packs énergétiques prêts à louer.

L'application doit permettre à un client de :

1.  consulter les produits et packs disponibles ;
2.  utiliser un calculateur pour déterminer ses besoins énergétiques ;
3.  obtenir une recommandation de matériel ou de pack ;
4.  sélectionner ses dates et son lieu ;
5.  envoyer une demande de réservation ;
6.  contacter l'entreprise via WhatsApp avec un message prérempli ;
7.  éventuellement payer un acompte dans une future version.

L'application doit être pensée pour le **marché tunisien**, avec la
monnaie **TND** et une interface principalement en **français**, avec
une architecture permettant d'ajouter l'arabe plus tard.

------------------------------------------------------------------------

# 2. Stack technique obligatoire

Utilise exactement cette stack pour le MVP :

### Backend

-   PHP
-   Laravel
-   Laravel Blade
-   Eloquent ORM
-   Laravel Validation
-   Laravel Authentication si nécessaire

### Frontend

-   Blade
-   HTML5
-   CSS3
-   Bootstrap 5
-   Bootstrap Icons
-   JavaScript vanilla
-   éventuellement AJAX / Fetch API lorsque cela améliore l'expérience

### Base de données

-   MySQL
-   gestion et administration via phpMyAdmin
-   migrations Laravel obligatoires

### Architecture

Utiliser une architecture Laravel classique et simple :

``` text
app/
├── Http/
│   ├── Controllers/
│   └── Requests/
├── Models/
└── Services/

database/
├── migrations/
└── seeders/

resources/
├── views/
│   ├── layouts/
│   ├── home/
│   ├── products/
│   ├── packs/
│   ├── calculator/
│   ├── reservations/
│   ├── faq/
│   ├── contact/
│   └── admin/
└── css/
└── js/

routes/
└── web.php

public/
├── images/
└── ...
```

Ne pas utiliser de framework frontend lourd comme React, Vue ou Angular
pour le MVP.

Ne pas utiliser une architecture inutilement complexe.

Le code doit être :

-   simple ;
-   lisible ;
-   maintenable ;
-   bien organisé ;
-   commenté uniquement lorsque nécessaire ;
-   adapté à un développeur qui veut pouvoir comprendre facilement le
    projet.

------------------------------------------------------------------------

# 3. Objectif business

L'entreprise loue du matériel permettant aux clients d'avoir
temporairement de l'électricité lorsqu'une alimentation classique est
insuffisante ou indisponible.

### Cas d'utilisation principaux

## A. Événements

Exemples :

-   mariage ;
-   anniversaire ;
-   festival ;
-   concert ;
-   stand ;
-   marché ;
-   événement professionnel ;
-   événement en plein air.

Les besoins peuvent inclure :

-   éclairage ;
-   enceinte audio ;
-   DJ ;
-   télévision ;
-   réfrigérateur ;
-   ordinateur ;
-   téléphone ;
-   chargeurs ;
-   petits équipements.

## B. Chantiers

Exemples :

-   chantier de construction ;
-   bureau temporaire ;
-   éclairage de chantier ;
-   outils électriques ;
-   perceuse ;
-   meuleuse ;
-   pompe ;
-   ordinateur ;
-   imprimante.

------------------------------------------------------------------------

# 4. Personas

Créer au minimum les personas suivants.

### Persona 1 --- Organisateur d'événement

Il connaît ses appareils mais ne sait pas combien de
batteries/panneaux/onduleurs il lui faut.

Il doit pouvoir :

``` text
Choisir ses appareils
        ↓
Indiquer quantité + durée
        ↓
Calculer ses besoins
        ↓
Recevoir une recommandation
        ↓
Choisir un pack
        ↓
Demander une réservation
```

### Persona 2 --- Responsable de chantier

Il a besoin d'énergie pendant une journée ou plusieurs jours.

Il peut avoir des équipements avec des **pics de démarrage**, par
exemple :

-   perceuse ;
-   meuleuse ;
-   pompe ;
-   moteur.

Le calculateur doit donc tenir compte de la puissance de démarrage.

### Persona 3 --- Client qui ne connaît rien au solaire

Il doit pouvoir utiliser le calculateur sans connaître :

-   les Wh ;
-   les Ah ;
-   le DoD ;
-   le rendement ;
-   la puissance de crête.

L'interface doit donc expliquer simplement les termes techniques.

------------------------------------------------------------------------

# 5. Fonctionnalités publiques

## 5.1 Accueil

Créer une page d'accueil moderne et professionnelle.

Sections :

### Hero

Titre :

> Besoin d'électricité temporaire ? Nous avons la solution.

Sous-titre expliquant la location de :

-   panneaux solaires ;
-   batteries ;
-   onduleurs ;
-   packs énergétiques.

Boutons :

``` text
Calculer mes besoins
Voir les packs
Réserver
WhatsApp
```

### Section avantages

Exemples :

-   Installation simple
-   Énergie temporaire
-   Packs adaptés
-   Livraison disponible
-   Assistance technique

### Section packs populaires

Afficher 3 à 6 packs.

### Section fonctionnement

``` text
1. Décrivez vos besoins
2. Calculez votre consommation
3. Choisissez votre solution
4. Réservez
```

### CTA final

Bouton WhatsApp + bouton Calculateur.

------------------------------------------------------------------------

# 6. Catalogue

Créer une page :

``` text
/catalogue
```

Afficher les produits sous forme de cards Bootstrap.

Filtres :

-   catégorie ;
-   puissance ;
-   prix ;
-   disponibilité.

Catégories :

``` text
Panneaux
Batteries
Onduleurs
Chargeurs / MPPT
Accessoires
Générateurs
```

Chaque produit doit afficher :

-   photo ;
-   nom ;
-   référence ;
-   catégorie ;
-   puissance ;
-   caractéristiques principales ;
-   prix de location ;
-   disponibilité ;
-   bouton "Voir détails".

------------------------------------------------------------------------

# 7. Détail produit

Route :

``` text
/products/{id}
```

Afficher :

-   image ;
-   nom ;
-   référence ;
-   description ;
-   caractéristiques techniques ;
-   puissance ;
-   tension ;
-   capacité ;
-   prix journalier ;
-   caution ;
-   disponibilité ;
-   bouton réserver.

------------------------------------------------------------------------

# 8. Packs

Créer une section dédiée aux packs.

Exemples :

### Pack Événement 1 Nuit

Contient :

-   panneaux ;
-   batterie ;
-   onduleur ;
-   câbles.

### Pack Chantier Journée

Contient :

-   panneaux ;
-   batterie ;
-   onduleur ;
-   câbles.

### Pack Stand Marché

Contient :

-   batterie ;
-   petit panneau solaire ;
-   onduleur.

Chaque pack possède :

-   nom ;
-   description ;
-   image ;
-   prix ;
-   caution ;
-   contenu ;
-   puissance totale ;
-   énergie disponible ;
-   usages recommandés.

------------------------------------------------------------------------

# 9. Calculateur énergétique

Créer une page :

``` text
/calculator
```

Le calculateur doit être très simple à utiliser.

## Étape 1 --- Type de projet

Choix :

``` text
Événement
Chantier
Stand
Autre
```

## Étape 2 --- Ajouter des appareils

L'utilisateur peut sélectionner un appareil existant :

``` text
Éclairage LED
Télévision
Réfrigérateur
Ordinateur
Enceinte
DJ
Perceuse
Meuleuse
Pompe
Chargeur téléphone
Autre
```

Ou choisir :

``` text
Appareil personnalisé
```

Pour chaque appareil :

``` text
Nom
Puissance en W
Quantité
Nombre d'heures d'utilisation
Utilisation :
    Jour
    Nuit
    Jour + Nuit

Pic de démarrage :
    Non
    Oui
```

------------------------------------------------------------------------

# 10. Calcul énergétique

Utiliser les valeurs par défaut suivantes :

``` text
Rendement système = 0.85
Marge énergie = 20%
DoD lithium = 80%
DoD plomb = 50%
Heures de soleil utilisables = 4.5 h/jour
Facteur onduleur = 1.25
Surge moteur = 2x
```

## Énergie d'un appareil

Formule :

``` text
Énergie = Puissance × Quantité × Durée
```

Exemple :

``` text
Éclairage :
100 W × 4 × 5 h
= 2000 Wh
```

## Énergie totale

Additionner toutes les consommations :

``` text
Total Wh = Σ énergie des appareils
```

Ajouter une marge de sécurité de 20 % :

``` text
Énergie avec marge =
Total Wh × 1.20
```

Puis prendre en compte le rendement :

``` text
Énergie système =
Énergie avec marge / 0.85
```

Afficher clairement les résultats.

------------------------------------------------------------------------

# 11. Calcul de la puissance simultanée

Calculer la puissance maximale nécessaire lorsque plusieurs appareils
fonctionnent en même temps.

``` text
Puissance simultanée =
Σ puissances des appareils utilisés simultanément
```

Recommandation de l'onduleur :

``` text
Onduleur recommandé =
Puissance simultanée × 1.25
```

Arrondir ensuite vers une puissance d'onduleur réellement disponible.

Exemple :

``` text
Puissance simultanée = 1 600 W

1600 × 1.25 = 2 000 W

Onduleur recommandé = 2 000 W
```

------------------------------------------------------------------------

# 12. Gestion des pics de démarrage

Certains appareils possèdent une puissance de démarrage supérieure à
leur puissance normale.

Exemples :

-   pompe ;
-   réfrigérateur ;
-   moteur ;
-   perceuse ;
-   meuleuse.

Si un appareil possède un pic :

``` text
Puissance de démarrage =
Puissance nominale × 2
```

Exemple :

``` text
Meuleuse = 1 000 W

Pic :
1000 × 2 = 2000 W
```

Le calculateur doit vérifier :

``` text
Puissance de crête nécessaire
```

et comparer cette valeur avec le **surge rating** de l'onduleur.

Le résultat doit indiquer :

``` text
Puissance continue recommandée
Puissance de crête recommandée
```

------------------------------------------------------------------------

# 13. Calcul de batterie

Permettre de choisir :

``` text
Lithium
Plomb
```

Valeurs :

``` text
Lithium DoD = 80%
Plomb DoD = 50%
```

Formule :

``` text
Capacité batterie Wh =
Énergie nécessaire / DoD
```

Prendre également en compte le rendement système selon l'architecture
choisie.

Ensuite convertir en Ah :

``` text
Ah = Wh / Voltage
```

Tensions disponibles :

``` text
12 V
24 V
48 V
```

Exemple :

``` text
Besoin = 4 000 Wh
DoD = 80%

4000 / 0.80
= 5000 Wh

À 24 V :

5000 / 24
≈ 208 Ah
```

Afficher :

``` text
Batterie recommandée :
≈ 5 kWh
≈ 208 Ah à 24 V
```

------------------------------------------------------------------------

# 14. Calcul des panneaux solaires

Pour une autonomie pendant la journée :

``` text
Puissance panneaux =
Énergie à produire /
(heures soleil × rendement système)
```

Utiliser par défaut :

``` text
4.5 heures de soleil
rendement = 0.85
```

Exemple :

``` text
Besoin = 4 000 Wh

4000 / (4.5 × 0.85)
≈ 1046 W

Recommandation :
≈ 1.1 kW de panneaux
```

Arrondir vers les puissances réellement disponibles dans le catalogue.

------------------------------------------------------------------------

# 15. Résultat du calculateur

Après calcul, afficher une page de résultat claire.

Exemple :

``` text
--------------------------------
VOS BESOINS
--------------------------------

Énergie totale :
4.8 kWh

Puissance simultanée :
1.6 kW

Puissance de crête :
3.2 kW

Batterie recommandée :
5 kWh

Onduleur recommandé :
2 kW / 4 kW surge

Panneaux recommandés :
1.1 kW
--------------------------------
```

Puis :

``` text
PACK RECOMMANDÉ

Pack Événement 1 Nuit

Batterie : 5 kWh
Onduleur : 2 kW
Panneaux : 1.2 kW

Prix estimé :
XXX TND / jour

[Voir le pack]
[Réserver]
[Contacter sur WhatsApp]
```

------------------------------------------------------------------------

# 16. Proposition automatique de packs

Après le calcul, rechercher les packs correspondant aux besoins.

Le système doit comparer :

``` text
énergie disponible du pack >= énergie nécessaire
ET
puissance onduleur >= puissance nécessaire
ET
surge >= puissance de crête
```

Afficher les meilleurs résultats.

Classement :

``` text
1. Meilleur choix
2. Option économique
3. Option supérieure
```

Ne jamais recommander un pack qui ne respecte pas les besoins calculés.

------------------------------------------------------------------------

# 17. Réservation

Créer :

``` text
/reservation
```

Formulaire :

``` text
Nom
Prénom
Téléphone
Email
Type de projet
Date début
Date fin
Lieu
Adresse
Livraison :
    Oui / Non

Pack sélectionné
Résultat du calcul
Message supplémentaire
```

Option :

``` text
CIN
```

Le CIN doit être traité comme une donnée sensible et ne doit pas être
obligatoire dans le MVP.

------------------------------------------------------------------------

# 18. Disponibilité

Le système doit vérifier si un pack ou produit est déjà réservé pendant
la période sélectionnée.

Une ressource ne doit pas pouvoir être réservée deux fois pour la même
période si sa quantité disponible est insuffisante.

Prévoir une structure permettant de gérer :

``` text
Quantité totale
Quantité réservée
Quantité disponible
```

------------------------------------------------------------------------

# 19. Statuts de réservation

Créer les statuts :

``` text
pending
confirmed
cancelled
completed
rejected
```

Workflow :

``` text
Client envoie demande
        ↓
pending
        ↓
Admin vérifie disponibilité
        ↓
confirmed
```

------------------------------------------------------------------------

# 20. WhatsApp

Ajouter un bouton WhatsApp.

Le message doit être automatiquement généré.

Exemple de structure :

``` text
Bonjour,

Je souhaite réserver une solution énergétique.

Projet : Mariage
Date : XX/XX/XXXX
Lieu : Tunis

Besoin énergétique :
4.8 kWh

Puissance :
1.6 kW

Batterie recommandée :
5 kWh

Onduleur recommandé :
2 kW

Pack conseillé :
Pack Événement 1 Nuit

Merci de me confirmer la disponibilité et le prix.
```

Utiliser un numéro WhatsApp configurable dans les paramètres de
l'application.

Ne pas hardcoder le numéro dans plusieurs fichiers.

------------------------------------------------------------------------

# 21. Admin Dashboard

Créer un espace :

``` text
/admin
```

L'administration doit permettre de gérer :

### Dashboard

Afficher :

``` text
Nombre de produits
Nombre de packs
Réservations en attente
Réservations confirmées
Revenus estimés
Produits disponibles
```

### Produits

CRUD :

``` text
Create
Read
Update
Delete
```

Champs :

``` text
name
reference
category
description
power
voltage
capacity
unit
daily_price
deposit
quantity
image
is_active
```

### Packs

CRUD :

``` text
name
description
price
deposit
energy_capacity
continuous_power
surge_power
is_active
image
```

### Contenu des packs

Permettre d'associer plusieurs produits à un pack.

Exemple :

``` text
Pack Événement
    → 2 panneaux
    → 1 batterie
    → 1 onduleur
    → câbles
```

Utiliser une table pivot.

### Réservations

Afficher :

-   client ;
-   dates ;
-   lieu ;
-   pack ;
-   statut ;
-   montant ;
-   caution ;
-   résultat du calcul.

Actions :

``` text
Voir
Confirmer
Refuser
Annuler
Marquer terminée
```

### Disponibilité

Afficher les réservations sous forme de calendrier si possible.

------------------------------------------------------------------------

# 22. Pages obligatoires

Créer au minimum :

``` text
/
/catalogue
/products/{id}
/packs
/packs/{id}
/calculator
/reservation
/faq
/conditions
/contact
/login
/admin
/admin/products
/admin/packs
/admin/reservations
/admin/availability
```

------------------------------------------------------------------------

# 23. Modèle de base de données

Créer les migrations Laravel correspondantes.

## users

``` text
id
name
email
phone
password
role
is_active
created_at
updated_at
```

Rôles minimum :

``` text
admin
```

Prévoir la possibilité d'ajouter d'autres rôles plus tard.

------------------------------------------------------------------------

## categories

``` text
id
name
description
created_at
updated_at
```

------------------------------------------------------------------------

## products

``` text
id
category_id
name
reference
description
power_w
voltage_v
capacity_wh
capacity_ah
surge_power_w
daily_price
deposit
quantity
image
is_active
created_at
updated_at
```

Certains champs doivent pouvoir être NULL car ils ne sont pas
applicables à tous les produits.

------------------------------------------------------------------------

## packs

``` text
id
name
description
price_per_day
deposit
energy_capacity_wh
continuous_power_w
surge_power_w
image
is_active
created_at
updated_at
```

------------------------------------------------------------------------

## pack_products

Table pivot :

``` text
id
pack_id
product_id
quantity
```

------------------------------------------------------------------------

## appliances

Créer une bibliothèque d'appareils pour le calculateur :

``` text
id
name
default_power_w
default_duration_hours
has_startup_surge
startup_factor
category
created_at
updated_at
```

Exemples :

``` text
TV
LED
Réfrigérateur
Perceuse
Meuleuse
Pompe
Ordinateur
Enceinte
```

------------------------------------------------------------------------

## quotes

Le calculateur peut sauvegarder les résultats.

``` text
id
project_type
total_energy_wh
energy_with_margin_wh
max_simultaneous_power_w
peak_power_w
recommended_battery_wh
recommended_battery_ah
battery_voltage
recommended_inverter_w
recommended_solar_w
recommended_pack_id
created_at
updated_at
```

------------------------------------------------------------------------

## quote_items

``` text
id
quote_id
appliance_id nullable
name
power_w
quantity
duration_hours
usage_period
has_startup_surge
startup_power_w
energy_wh
```

------------------------------------------------------------------------

## reservations

``` text
id
user_id nullable
quote_id nullable
pack_id nullable
customer_name
customer_phone
customer_email
cin nullable
project_type
start_date
end_date
location
address
delivery_required
delivery_fee nullable
status
estimated_price
deposit_amount
customer_message
created_at
updated_at
```

------------------------------------------------------------------------

## reservation_products

Si nécessaire pour réserver des produits individuels :

``` text
id
reservation_id
product_id
quantity
```

------------------------------------------------------------------------

## availability

Prévoir une structure permettant de suivre la disponibilité des
produits/packs.

``` text
id
product_id nullable
pack_id nullable
date
quantity_total
quantity_reserved
quantity_available
```

Éviter les doublons de disponibilité.

------------------------------------------------------------------------

## settings

Pour les paramètres globaux :

``` text
id
key
value
created_at
updated_at
```

Exemples :

``` text
whatsapp_number
default_system_efficiency
default_energy_margin
default_solar_hours
default_inverter_factor
default_lithium_dod
default_lead_dod
```

Cela permet à l'administrateur de modifier les valeurs sans modifier le
code.

------------------------------------------------------------------------

# 24. Relations Eloquent

Créer les relations nécessaires.

Exemples :

``` text
Category hasMany Products

Product belongsTo Category

Pack belongsToMany Products

Product belongsToMany Packs

Quote hasMany QuoteItems

Quote belongsTo Pack

Reservation belongsTo Quote

Reservation belongsTo Pack

Reservation belongsTo User
```

------------------------------------------------------------------------

# 25. Validation

Toutes les données utilisateur doivent être validées côté serveur.

Exemples :

``` text
name → required|string
email → nullable|email
phone → required
start_date → required|date
end_date → required|date|after_or_equal:start_date
power → required|numeric|min:1
quantity → required|integer|min:1
duration → required|numeric|min:0.1
```

Ne jamais faire confiance uniquement à la validation JavaScript.

------------------------------------------------------------------------

# 26. Sécurité

Implémenter :

-   CSRF Laravel ;
-   validation serveur ;
-   authentification admin ;
-   middleware admin ;
-   protection des routes admin ;
-   protection contre les accès non autorisés ;
-   Eloquent / Query Builder pour éviter les injections SQL ;
-   échappement Blade ;
-   validation des uploads d'images ;
-   limitation des types et tailles de fichiers.

Ne jamais stocker les mots de passe en clair.

Utiliser le système de hashing Laravel.

------------------------------------------------------------------------

# 27. UI / UX

Utiliser **Bootstrap 5**.

Le site doit être :

-   responsive ;
-   mobile-first ;
-   propre ;
-   moderne ;
-   professionnel ;
-   rapide à comprendre.

Palette recommandée :

``` text
Blanc
Noir / gris foncé
Jaune solaire / orange
Vert pour les disponibilités
Rouge pour les erreurs
```

Utiliser :

-   navbar responsive ;
-   cards ;
-   badges ;
-   alerts ;
-   modals ;
-   forms ;
-   tables ;
-   pagination ;
-   breadcrumbs ;
-   accordions FAQ ;
-   Bootstrap Icons.

------------------------------------------------------------------------

# 28. Expérience du calculateur

Le calculateur doit être présenté comme un assistant étape par étape.

Exemple :

``` text
Étape 1
Quel est votre projet ?

[Événement]
[Chantier]
[Stand]

        ↓

Étape 2
Quels appareils utilisez-vous ?

[+ Ajouter un appareil]

        ↓

Étape 3
Quand les utilisez-vous ?

Jour / Nuit

        ↓

Étape 4
Résultat

Votre besoin :
4.8 kWh

        ↓

Pack recommandé

[Réserver]
[WhatsApp]
```

Afficher des explications simples sous les termes techniques.

Exemple :

> Le DoD indique la partie de la capacité de la batterie que nous
> pouvons utiliser sans réduire excessivement sa durée de vie.

------------------------------------------------------------------------

# 29. Pseudocode du calculateur

Utiliser une logique similaire à :

``` text
totalEnergy = 0
maxPower = 0
peakPower = 0

for each appliance:

    energy =
        power
        × quantity
        × duration

    totalEnergy += energy

    simultaneousPower =
        power × quantity

    if simultaneousPower > maxPower:
        maxPower = simultaneousPower

    if appliance.hasStartupSurge:
        startupPower =
            power
            × quantity
            × startupFactor

        peakPower =
            max(peakPower, startupPower)
    else:
        peakPower =
            max(peakPower, simultaneousPower)

energyWithMargin =
    totalEnergy × 1.20

systemEnergy =
    energyWithMargin / 0.85

batteryEnergy =
    systemEnergy / DoD

batteryAh =
    batteryEnergy / selectedVoltage

inverterContinuous =
    maxPower × 1.25

solarPower =
    systemEnergy /
    (4.5 × 0.85)

find suitable packs

return results
```

Adapter la logique si nécessaire afin d'éviter de compter deux fois le
rendement.

L'implémentation finale doit rester cohérente physiquement et
mathématiquement.

------------------------------------------------------------------------

# 30. Scénario de test 1 --- Événement de nuit

Exemple :

``` text
10 × LED = 20 W
5 heures

2 × enceinte = 100 W
4 heures

1 × TV = 120 W
4 heures

1 × réfrigérateur = 150 W
6 heures
```

Calculer :

-   Wh total ;
-   marge ;
-   puissance simultanée ;
-   puissance de crête ;
-   batterie ;
-   onduleur ;
-   panneaux nécessaires.

Le réfrigérateur doit être considéré comme un appareil pouvant avoir un
pic de démarrage.

------------------------------------------------------------------------

# 31. Scénario de test 2 --- Chantier

Exemple :

``` text
2 × perceuse = 800 W
2 heures

1 × meuleuse = 1000 W
1 heure

4 × LED = 30 W
8 heures

1 × ordinateur = 100 W
8 heures
```

Calculer :

-   énergie totale ;
-   puissance simultanée ;
-   puissance de crête ;
-   batterie ;
-   onduleur ;
-   panneaux.

Le résultat doit prendre en compte les pics des moteurs.

------------------------------------------------------------------------

# 32. Gestion des erreurs

Afficher des messages simples.

Exemples :

``` text
Veuillez ajouter au moins un appareil.

La quantité doit être supérieure à 0.

La durée doit être supérieure à 0.

Aucun pack ne correspond exactement à vos besoins.

Nous vous recommandons de contacter notre équipe.
```

------------------------------------------------------------------------

# 33. Seeders

Créer des seeders pour faciliter les tests.

Ajouter au minimum :

### Catégories

``` text
Panneaux
Batteries
Onduleurs
Accessoires
Chargeurs / MPPT
Générateurs
```

### Produits

Créer plusieurs produits fictifs réalistes.

### Packs

Créer au minimum :

``` text
Pack Stand
Pack Événement
Pack Chantier
```

### Appareils

Créer une bibliothèque d'au moins 10 appareils.

### Admin

Créer un compte administrateur de test.

Ne pas mettre de mot de passe réel ou sensible dans le code final.

------------------------------------------------------------------------

# 34. Routes Laravel

Utiliser des routes propres et RESTful lorsque possible.

Exemple :

``` php
Route::get('/', ...);

Route::get('/catalogue', ...);

Route::get('/products/{product}', ...);

Route::get('/packs', ...);

Route::get('/packs/{pack}', ...);

Route::get('/calculator', ...);

Route::post('/calculator/calculate', ...);

Route::get('/reservation', ...);

Route::post('/reservation', ...);

Route::get('/faq', ...);

Route::get('/conditions', ...);

Route::get('/contact', ...);
```

Pour l'administration :

``` text
/admin
/admin/products
/admin/packs
/admin/reservations
/admin/availability
```

Utiliser des controllers séparés.

------------------------------------------------------------------------

# 35. Organisation des Controllers

Créer par exemple :

``` text
HomeController
ProductController
PackController
CalculatorController
ReservationController
ContactController
FaqController
Admin/DashboardController
Admin/ProductController
Admin/PackController
Admin/ReservationController
Admin/AvailabilityController
```

Ne pas mettre toute la logique dans un seul controller.

Pour les calculs énergétiques complexes, créer un service simple :

``` text
EnergyCalculatorService
```

Le service doit uniquement gérer la logique de calcul.

------------------------------------------------------------------------

# 36. Architecture des vues Blade

Créer :

``` text
layouts/app.blade.php
layouts/admin.blade.php

components/navbar.blade.php
components/footer.blade.php
components/product-card.blade.php
components/pack-card.blade.php
components/alert.blade.php
```

Puis :

``` text
home/index.blade.php

products/index.blade.php
products/show.blade.php

packs/index.blade.php
packs/show.blade.php

calculator/index.blade.php
calculator/result.blade.php

reservations/create.blade.php
reservations/success.blade.php

faq/index.blade.php
conditions/index.blade.php
contact/index.blade.php
```

------------------------------------------------------------------------

# 37. Admin UI

Créer un layout spécifique :

``` text
Sidebar
Navbar
Content
```

Sidebar :

``` text
Dashboard
Produits
Packs
Réservations
Disponibilité
Appareils
Paramètres
Déconnexion
```

Utiliser Bootstrap uniquement, sans template admin lourd pour le MVP.

------------------------------------------------------------------------

# 38. Gestion des prix

Tous les prix doivent être exprimés en :

``` text
TND
```

Exemple :

``` text
150 TND / jour
```

Ne jamais stocker `"150 TND"` en base.

Stocker uniquement :

``` text
150.00
```

et afficher :

``` text
150.00 TND
```

------------------------------------------------------------------------

# 39. Livraison

Prévoir :

``` text
delivery_required
```

Si livraison :

``` text
zone
adresse
frais
```

Pour le MVP, les frais peuvent être configurés manuellement.

Prévoir une structure permettant plus tard de gérer :

``` text
Tunis
Ariana
Ben Arous
Manouba
Sousse
Sfax
Nabeul
etc.
```

------------------------------------------------------------------------

# 40. Conditions

Créer une page Conditions contenant :

-   caution ;
-   retard ;
-   annulation ;
-   casse ;
-   perte ;
-   utilisation incorrecte ;
-   responsabilité du client ;
-   livraison ;
-   retour du matériel.

Ne pas inventer de conditions légales définitives : utiliser des textes
clairement identifiés comme **à valider par l'entreprise**.

------------------------------------------------------------------------

# 41. FAQ

Créer des questions comme :

``` text
Combien coûte la location ?

Comment fonctionne la caution ?

Livrez-vous ?

Puis-je louer uniquement une batterie ?

Combien de temps faut-il pour installer le système ?

Puis-je utiliser une perceuse ?

Que se passe-t-il si mon besoin dépasse la capacité prévue ?

Puis-je réserver plusieurs jours ?

Comment fonctionne la réservation ?
```

Utiliser Bootstrap Accordion.

------------------------------------------------------------------------

# 42. Responsive design

Tester au minimum :

``` text
Mobile : 375px
Tablet : 768px
Desktop : 1366px
```

Le calculateur doit être particulièrement facile à utiliser sur mobile.

------------------------------------------------------------------------

# 43. SEO de base

Ajouter :

-   title ;
-   meta description ;
-   headings corrects ;
-   URLs lisibles ;
-   alt text sur les images ;
-   structure HTML sémantique.

Exemple :

``` text
/location-panneaux-solaires
/location-batterie
/calculateur-energie
```

------------------------------------------------------------------------

# 44. Ce qui est hors MVP

Ne pas implémenter pour l'instant :

-   paiement en ligne ;
-   application mobile ;
-   intelligence artificielle complexe ;
-   géolocalisation avancée ;
-   système comptable ;
-   intégration ERP ;
-   notifications SMS payantes ;
-   architecture microservices.

Préparer cependant le projet pour pouvoir les ajouter plus tard.

------------------------------------------------------------------------

# 45. Checklist de développement

Développer dans cet ordre :

### Jour 1

-   création Laravel ;
-   configuration MySQL ;
-   Bootstrap ;
-   layout ;
-   navbar/footer ;
-   migrations.

### Jour 2

-   modèles ;
-   relations ;
-   seeders ;
-   produits ;
-   catégories.

### Jour 3

-   catalogue ;
-   détails produit ;
-   packs.

### Jour 4

-   calculateur ;
-   logique énergétique ;
-   tests des formules.

### Jour 5

-   résultats ;
-   recommandations de packs ;
-   WhatsApp.

### Jour 6

-   réservation ;
-   validation ;
-   disponibilité.

### Jour 7

-   authentification admin ;
-   dashboard ;
-   CRUD produits/packs.

### Jour 8

-   gestion réservations ;
-   disponibilité ;
-   paramètres.

### Jour 9

-   responsive design ;
-   FAQ ;
-   conditions ;
-   contact ;
-   erreurs.

### Jour 10

-   tests ;
-   sécurité ;
-   nettoyage du code ;
-   corrections ;
-   préparation du déploiement.

------------------------------------------------------------------------

# 46. Tests obligatoires

Créer des tests pour :

### Calculateur

Tester :

-   calcul Wh ;
-   marge de 20 % ;
-   rendement ;
-   DoD ;
-   conversion Wh → Ah ;
-   puissance simultanée ;
-   facteur onduleur ;
-   startup surge ;
-   puissance solaire ;
-   recommandation de packs.

### Réservation

Tester :

-   dates invalides ;
-   date de fin avant date de début ;
-   disponibilité ;
-   réservation valide ;
-   statut.

### Admin

Tester :

-   accès autorisé ;
-   accès non autorisé ;
-   CRUD produits ;
-   CRUD packs.

------------------------------------------------------------------------

# 47. Règles importantes pour l'agent

Tu dois :

1.  **Créer un vrai projet Laravel fonctionnel**, pas seulement fournir
    des exemples.
2.  Fournir les migrations complètes.
3.  Fournir les modèles Eloquent.
4.  Fournir les controllers.
5.  Fournir les routes.
6.  Fournir les vues Blade.
7.  Fournir le JavaScript nécessaire.
8.  Utiliser Bootstrap 5.
9.  Fournir les seeders.
10. Fournir les validations.
11. Implémenter réellement le calculateur.
12. Implémenter réellement la recommandation des packs.
13. Implémenter le système de réservation.
14. Implémenter l'administration.
15. Utiliser MySQL.
16. Garder le code simple et compréhensible.
17. Ne pas inventer de fonctionnalités inutiles.
18. Ne pas utiliser React/Vue pour le MVP.
19. Ne pas utiliser de données fictives dans la logique finale sans les
    identifier clairement.
20. Ne pas mettre de secrets ou mots de passe réels dans le dépôt.

------------------------------------------------------------------------

# 48. Format de travail attendu de l'agent

Ne génère pas tout le projet dans un seul énorme bloc impossible à
maintenir.

Travaille **étape par étape**.

Pour chaque étape :

1.  expliquer brièvement ce qui est fait ;
2.  donner les fichiers créés/modifiés ;
3.  donner le code complet du fichier lorsque nécessaire ;
4.  expliquer où placer chaque fichier ;
5.  donner les commandes Laravel à exécuter ;
6.  indiquer les migrations à lancer ;
7.  vérifier les erreurs potentielles ;
8.  passer à l'étape suivante uniquement lorsque la précédente est
    cohérente.

Lorsque tu modifies un fichier existant, indique clairement :

``` text
Fichier :
app/Http/Controllers/CalculatorController.php

Action :
Remplacer complètement le fichier
```

ou :

``` text
Chercher :
[ancien bloc]

Remplacer par :
[nouveau bloc]
```

Ne jamais demander au développeur de deviner où placer le code.

------------------------------------------------------------------------

# 49. Première étape à réaliser

Commence par :

### Étape 1 --- Architecture du projet

Fournis :

1.  architecture complète des dossiers ;
2.  liste des migrations ;
3.  schéma des relations entre tables ;
4.  liste des modèles ;
5.  liste des controllers ;
6.  liste des routes ;
7.  liste des vues Blade ;
8.  liste des composants Bootstrap ;
9.  architecture du calculateur ;
10. ordre exact de développement.

Ensuite, commence par créer :

``` text
Laravel project
+
MySQL database
+
Bootstrap 5
+
base layout
+
navbar
+
footer
+
migrations
+
models
+
seeders
```

Puis continue progressivement avec le reste du projet.

# Résultat final attendu

À la fin, l'application doit permettre à un utilisateur tunisien de
faire ce parcours complet :

``` text
ACCUEIL
   ↓
CALCULATEUR
   ↓
Sélection des appareils
   ↓
Calcul énergétique
   ↓
Batterie + Onduleur + Panneaux recommandés
   ↓
Packs compatibles
   ↓
Choix du pack
   ↓
Dates + lieu
   ↓
Demande de réservation
   ↓
Confirmation
   ↓
WhatsApp
```

Et à l'administrateur :

``` text
LOGIN ADMIN
   ↓
DASHBOARD
   ├── Produits
   ├── Packs
   ├── Appareils
   ├── Réservations
   ├── Disponibilité
   └── Paramètres
```

Le résultat doit être un **MVP réellement fonctionnel**, propre,
responsive et prêt à être testé localement avec **Laravel +
MySQL/phpMyAdmin + Blade + Bootstrap 5**.
