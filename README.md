OBJECTIF DU TP
L’objectif de ce TP est de refondre le projet fourni dans le ZIP en appliquant les bonnes pratiques de conception et de développement vues en cours. Vous devez réorganiser, clarifier et améliorer le code existant afin qu’il soit plus lisible, maintenable et évolutif, tout en conservant les mêmes fonctionnalités. Le but n’est pas de tout réécrire, mais d’améliorer la structure interne (qualité du code, organisation, séparation des responsabilités).

Contexte fonctionnel du projet
L’application fournie simule un mini système de gestion avec liste d’éléments et opérations CRUD de base, avec stockage simple (fichier, base légère ou mémoire) et une interface minimaliste (web ou console). Le code fonctionne, mais présente des faiblesses : mélange des responsabilités, nommages et indentation incohérents, duplication de code, peu de documentation, pas d’architecture claire.



Plan global (objectifs à respecter)

Séparer présentation / logique métier / accès aux données.

Valider et sanitiser toutes les entrées.

Contrôler l’accès admin de manière simple.

Persister proprement en JSON (schémas simples).

Améliorer lisibilité (nomenclature, indentation, commentaires utiles).

Ajouter outils qualité : PHP-CS-Fixer, .gitignore, README, tests unitaires simples (PHPUnit).

Respecter règles fonctionnelles : login par email, liste services, réservation/consultation/annulation filtrée, règles anti-double booking, annulation seulement pour futur.

