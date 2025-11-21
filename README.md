# Application de réservation de services

## 📌 Présentation du projet
Ce projet est une application web permettant la gestion et la réservation de services (ex : salles, équipements, ateliers).  
Elle propose un système de connexion simplifiée par email, un catalogue de services consultable, ainsi qu'un module d’administration permettant d’ajouter des services et des créneaux de réservation.

Ce projet a été réalisé dans le cadre d’un travail pratique visant à restructurer un code existant et mal organisé pour l'adapter à une architecture plus propre et modulaire.

---

## 🎯 Objectifs fonctionnels

- Connexion sans mot de passe via email (session simulée)
- Consultation des services et de leurs créneaux disponibles
- Réservation et annulation selon l’utilisateur connecté
- Accès administrateur permettant :
  - d’ajouter un service
  - d’ajouter des créneaux
  - d’afficher toutes les réservations
- Persistance via fichier JSON

---

## 🛠 Choix techniques et justification

| Élément | Choix | Raison |
|---------|-------|--------|
| Backend | PHP procédural modulaire | Simplicité, respect du code de départ, facilité de déploiement |
| Stockage | JSON (`data.json`) | Base légère, pas de serveur SQL, persistance simple pour tests |
| Frontend | JavaScript Vanilla + HTML/CSS | Légèreté, pas de framework imposé |
| Session | Cookie + stockage JSON | Simule une authentification sans mot de passe |
| Architecture | Séparation des rôles MVC simplifiée | Meilleure lisibilité et maintenance |

Ce découpage permet de respecter l’exigence du professeur : **séparer présentation, logique métier et accès aux données**.

---

## 📂 Structure du projet

project/
│ index.php → page principale + affichage
│ api.php → points d’accès JSON (fetch)
│ data.json → base de données simulée
│ README.md
│
├── backend/
│ ├── db.php → gestion lecture/écriture JSON
│ ├── actions.php → logique métier (booking, ajout, annulation)
│ └── auth.php → connexion et rôle utilisateur
│
└── frontend/
├── assets/app.js → fetch + affichage dynamique
└── assets/styles.css → styles graphiques


---

## 📦 Installation & Exécution

### ✔ Prérequis

- PHP installé  
- Aucun serveur externe nécessaire

### ▶ Lancer l’application

```sh
php -S localhost:8000

Puis ouvrir dans un navigateur :

http://localhost:8000