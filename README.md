# CBSC Application - Backend

> **Gestion de Club de Pétanque** - Une application web progressive (PWA) facilitant la gestion administrative et les communications au sein d'un club de pétanque.

## 📋 Table des matières

- [À propos](#-à-propos)
- [Fonctionnalités](#-fonctionnalités)
- [Structure du projet](#-structure-du-projet)
- [Prérequis](#-prérequis)
- [Installation](#-installation)
- [Configuration](#-configuration)
- [Démarrage](#-démarrage)
- [API Documentation](#-api-documentation)
- [Architecture](#-architecture)
- [Base de données](#-base-de-données)
- [Authentification](#-authentification)
- [Notifications](#-notifications)
- [Tests](#-tests)
- [Déploiement](#-déploiement)

## 🎯 À propos

CBSC (Club Bouliste Saint Couatais) est une application web progressive conçue pour simplifier la gestion administrative d'un club de pétanque. Elle permet aux responsables de gérer les utilisateurs, d'organiser des convocations et d'envoyer des notifications en temps réel aux membres.

L'application est construite avec **Laravel 8** comme backend API RESTful et utilise des technologies modernes comme **Sanctum** pour l'authentification et les **Web Push Notifications** pour les communications.

## ✨ Fonctionnalités

### Gestion des utilisateurs
- ✅ Authentification sécurisée avec tokens
- ✅ Différents rôles : Membres licenciés et Responsables
- ✅ Gestion complète des profils utilisateurs
- ✅ Recherche et filtrage des utilisateurs

### Gestion des convocations
- ✅ Création et gestion des convocations
- ✅ Envoi d'invitations aux membres
- ✅ Réponse aux invitations (accepter/refuser)
- ✅ Filtrage et recherche des convocations
- ✅ Affichage des convocations personnelles

### Notifications
- ✅ Notifications Web Push en temps réel
- ✅ Souscription/désinscription aux notifications
- ✅ Notifications d'invitations de convocation

### Authentification et sécurité
- ✅ Authentification par email/mot de passe
- ✅ Tokens Sanctum personnels pour l'API
- ✅ Protection CORS intégrée
- ✅ Middlewares de gestion des rôles

## 📁 Structure du projet

```
cbsc-back-end/
├── app/
│   ├── Console/              # Commandes Artisan personnalisées
│   ├── Exceptions/           # Gestion des exceptions
│   ├── Http/
│   │   ├── Controllers/      # Contrôleurs API
│   │   ├── Kernel.php        # Middlewares HTTP
│   │   └── Middleware/       # Middlewares personnalisés
│   ├── Models/               # Modèles Eloquent
│   ├── Notifications/        # Classes de notifications
│   └── Providers/            # Fournisseurs de services
├── bootstrap/                # Fichiers d'amorçage
├── config/                   # Fichiers de configuration
├── database/
│   └── migrations/           # Migrations de base de données
├── public/                   # Fichiers publics (index.php, assets)
├── resources/                # Vues et langues
├── routes/
│   ├── api.php              # Routes API
│   ├── web.php              # Routes web
│   └── channels.php         # Canaux Websocket
├── storage/                  # Fichiers générés (logs, cache, uploads)
├── tests/                    # Tests unitaires et d'intégration
├── composer.json             # Dépendances PHP
├── package.json              # Dépendances Node.js
├── webpack.mix.js            # Configuration Webpack/Mix
└── .env.example              # Exemple de configuration
```

## 🔧 Prérequis

- **PHP** 7.3+ ou 8.0+
- **Composer** 2.0+
- **Node.js** 12+
- **npm** ou **yarn**
- **MySQL** 5.7+ ou **MariaDB**
- **Git**

## ⚙️ Installation

### 1. Cloner le repository
```bash
git clone https://github.com/BDoryan/cbsc-back-end.git
cd cbsc-back-end
```

### 2. Installer les dépendances PHP
```bash
composer install
```

### 3. Installer les dépendances Node.js
```bash
npm install
```

### 4. Copier le fichier d'environnement
```bash
cp .env.example .env
```

### 5. Générer la clé d'application
```bash
php artisan key:generate
```

### 6. Configurer la base de données (voir section Configuration)

### 7. Exécuter les migrations
```bash
php artisan migrate
```

## 🔐 Configuration

### Variables d'environnement (`.env`)

```bash
APP_NAME=CBSC
APP_ENV=local
APP_KEY=                           # Générée automatiquement
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cbsc
DB_USERNAME=root
DB_PASSWORD=

# Mail (pour les notifications)
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_NAME="${APP_NAME}"

# Web Push Notifications
WEBPUSH_PUBLIC_KEY=
WEBPUSH_PRIVATE_KEY=

# Autres services
CORS_ALLOWED_ORIGINS=*
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
```

### Configuration CORS
Modifier config/cors.php pour autoriser les origines de votre frontend.

## 🚀 Démarrage

### Mode développement
```bash
# Serveur Laravel
php artisan serve

# Compilation des assets (dans une autre terminale)
npm run dev
```

### Mode production
```bash
# Compilation optimisée
npm run production

# Cache de configuration
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## 📡 API Documentation

### Base URL
```
http://localhost:8000/api
```

### Authentification
Tous les endpoints (sauf `/users/login`) requièrent un token Sanctum dans l'en-tête:
```
Authorization: Bearer {token}
```

### Endpoints principaux

#### 👤 Utilisateurs

| Méthode | Endpoint | Description | Rôle |
|---------|----------|-------------|------|
| POST | `/user/login` | Connexion utilisateur | Public |
| GET | `/user/me` | Récupère l'utilisateur courant | Authentifié |
| POST | `/user/logout` | Déconnexion | Authentifié |
| GET | `/users` | Liste les utilisateurs paginée | Authentifié |
| GET | `/users/all` | Liste tous les utilisateurs | Authentifié |
| GET | `/users/licensed` | Liste les membres licenciés | Authentifié |
| GET | `/users/managing` | Liste les responsables | Authentifié |
| GET | `/users/search` | Recherche d'utilisateurs | Authentifié |
| GET | `/users/{id}` | Détails d'un utilisateur | Authentifié |
| POST | `/users` | Créer un utilisateur | Responsable |
| PUT | `/users/{id}` | Modifier un utilisateur | Responsable |
| DELETE | `/users/{id}` | Supprimer un utilisateur | Responsable |
| GET | `/users/{id}/generate/token` | Générer un token d'auth | Responsable |

#### 📢 Convocations

| Méthode | Endpoint | Description | Rôle |
|---------|----------|-------------|------|
| GET | `/convocations` | Liste toutes les convocations | Authentifié |
| GET | `/me/convocations` | Mes convocations | Authentifié |
| GET | `/convocations/{id}` | Détails d'une convocation | Authentifié |
| GET | `/convocations/search` | Recherche de convocations | Authentifié |
| POST | `/convocations` | Créer une convocation | Responsable |
| PUT | `/convocations/{id}` | Modifier une convocation | Responsable |
| DELETE | `/convocations/{id}` | Supprimer une convocation | Responsable |
| POST | `/convocations/{id}/accept` | Accepter une invitation | Authentifié |
| POST | `/convocations/{id}/decline` | Refuser une invitation | Authentifié |

#### 🔔 Notifications

| Méthode | Endpoint | Description |
|---------|----------|-------------|
| POST | `/subscribe` | S'abonner aux notifications Web Push |
| POST | `/unsubscribe` | Se désabonner des notifications |
| GET | `/notification/test` | Envoyer une notification de test |

### Exemple de requête
```bash
# Connexion
curl -X POST http://localhost:8000/api/user/login \
  -H "Content-Type: application/json" \
  -d '{"email":"user@example.com","password":"password"}'

# Récupérer mes convocations
curl -X GET http://localhost:8000/api/me/convocations \
  -H "Authorization: Bearer YOUR_TOKEN"
```

## 🏗️ Architecture

### Modèles de données

#### User
- Authentification et profil utilisateur
- Relations avec LicensedUser et ManagingUser

#### Convocation
- Représente une convocation (réunion/événement)
- Contient titre, contenu et date/heure
- Relations : hasMany invitations

#### ConvocationInvitation
- Représente une invitation d'une convocation à un utilisateur
- Statuts : pending, accepted, declined

#### LicensedUser & ManagingUser
- Relations polymorphes pour distinguer les rôles
- LicensedUser : membre licencié
- ManagingUser : responsable/administrateur

### Contrôleurs
- `UserController` : Gestion des utilisateurs
- `UserAuthController` : Authentification et tokens
- `ConvocationController` : Gestion des convocations
- `SubscriptionController` : Gestion des notifications Web Push

### Middlewares
- `auth:sanctum` : Authentification par token
- `managing` : Vérification du rôle de responsable
- CORS : Gestion des origines autorisées

## 🗄️ Base de données

### Tables principales
- `users` : Utilisateurs
- `convocations` : Convocations
- `convocation_invitations` : Invitations de convocations
- `licensed_users` : Relation polymorphe pour membres
- `managing_users` : Relation polymorphe pour responsables
- `personal_access_tokens` : Tokens Sanctum

### Migrations
Les migrations sont situées dans database/migrations/. Pour les exécuter :

```bash
# Exécuter les migrations
php artisan migrate

# Revenir en arrière
php artisan migrate:rollback

# Recréer la base de données
php artisan migrate:refresh

# Ajouter des données de test
php artisan db:seed
```

## 🔑 Authentification

### Stratégies implémentées

#### 1. Token Sanctum (API)
Authentification sans état avec tokens personnels
```php
Route::middleware('auth:sanctum')->group(function () {
    // Routes protégées
});
```

#### 2. Vérification des rôles
```php
Route::middleware('managing')->group(function () {
    // Uniquement accessibles aux responsables
});
```

### Génération de tokens
```bash
php artisan tinker
>>> $user = App\Models\User::first();
>>> $token = $user->createToken('app-token');
>>> $token->plainTextToken;
```

## 🔔 Notifications

### Web Push Notifications

Configuration dans config/webpush.php.

#### Générer les clés
```bash
php artisan webpush:vapid
```

#### Envoyer une notification
```php
$user->notify(new ConvocationInvitationNotification($convocation));
```

#### Classes de notifications
- `ConvocationInvitationNotification` : Notification d'invitation de convocation
- `MyAccountLoginNotification` : Notification de connexion

## ✅ Tests

### Exécuter les tests
```bash
# Tous les tests
php artisan test

# Seulement les tests unitaires
php artisan test --type=unit

# Avec rapport de couverture
php artisan test --coverage
```

Les tests sont situés dans le dossier tests/. Tests disponibles dans tests/Unit/.

## 🚀 Déploiement

### Préparation pour la production

1. **Vérifier les exigences**
   ```bash
   php artisan check
   ```

2. **Optimiser l'application**
   ```bash
   php artisan optimize
   php artisan config:cache
   php artisan route:cache
   php artisan view:cache
   ```

3. **Assets Front-end**
   ```bash
   npm run production
   ```

4. **Migrer la base de données**
   ```bash
   php artisan migrate --force
   ```

### Configuration du serveur HTTPS
Pour utiliser toutes les fonctionnalités (Web Push, caméra), un certificat SSL/HTTPS est obligatoire.

```bash
# Avec Let's Encrypt
certbot certonly --standalone -d votre-domaine.com
```

### Variables d'environnement production
```bash
APP_DEBUG=false
APP_ENV=production
SANCTUM_STATEFUL_DOMAINS=votre-domaine.com
CORS_ALLOWED_ORIGINS=https://votre-domaine.com
```

## 📝 Notes de version

### Statut du projet
Ce projet est en développement. Voir todo.md pour la liste des tâches en cours.

### Fonctionnalités planifiées
- [ ] Interfaces personnalisées pour les utilisateurs
- [ ] Recherche avancée de convocations et utilisateurs
- [ ] Notifications push complètes
- [ ] Sélection de la caméra (avant/arrière)
- [ ] Déploiement en production sous HTTPS

## 🤝 Contribution

Les contributions sont bienvenues ! Pour contribuer :

1. Fork le repository
2. Créer une branche (`git checkout -b feature/amazingfeature`)
3. Commit les modifications (`git commit -m 'Add amazingfeature'`)
4. Push vers la branche (`git push origin feature/amazingfeature`)
5. Ouvrir une Pull Request


## 📧 Contact

Pour toute question ou suggestion, veuillez contacter les responsables du projet.

---