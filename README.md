# CBSC Application - Backend

> **CBSC Application** - A Progressive Web Application (PWA) designed to simplify administrative management and communication within a petanque club.

## Table of Contents

* [About](#about)
* [Features](#features)
* [Project Structure](#project-structure)
* [Prerequisites](#prerequisites)
* [Installation](#installation)
* [Configuration](#configuration)
* [Getting Started](#getting-started)
* [API Documentation](#api-documentation)
* [Architecture](#architecture)
* [Database](#database)
* [Authentication](#authentication)
* [Notifications](#notifications)
* [Tests](#tests)
* [Deployment](#deployment)

## About

CBSC (Club Bouliste Saint Couatais) is a Progressive Web Application designed to simplify the administrative management of a petanque club. It allows managers to handle users, organize convocations (events/invitations), and send real-time notifications to members.

The application is built with **Laravel 8** as a RESTful backend API and uses modern technologies such as **Sanctum** for authentication and **Web Push Notifications** for communication.

## Features

### User Management

* Secure authentication with tokens
* Multiple roles: Licensed Members and Managers
* Full user profile management
* User search and filtering

### Convocation Management

* Creation and management of convocations
* Sending invitations to members
* Responding to invitations (accept/decline)
* Filtering and searching convocations
* Viewing personal convocations

### Notifications

* Real-time Web Push notifications
* Subscribe/unsubscribe to notifications
* Convocation invitation notifications

### Authentication and Security

* Email/password authentication
* Sanctum personal tokens for API
* Built-in CORS protection
* Role-based middleware

## Project Structure

```
cbsc-back-end/
├── app/
│   ├── Console/
│   ├── Exceptions/
│   ├── Http/
│   │   ├── Controllers/
│   │   ├── Kernel.php
│   │   └── Middleware/
│   ├── Models/
│   ├── Notifications/
│   └── Providers/
├── bootstrap/
├── config/
├── database/
│   └── migrations/
├── public/
├── resources/
├── routes/
│   ├── api.php
│   ├── web.php
│   └── channels.php
├── storage/
├── tests/
├── composer.json
├── package.json
├── webpack.mix.js
└── .env.example
```

## Prerequisites

* **PHP** 7.3+ or 8.0+
* **Composer** 2.0+
* **Node.js** 12+
* **npm** or **yarn**
* **MySQL** 5.7+ or **MariaDB**
* **Git**

## Installation

### 1. Clone the repository

```bash
git clone https://github.com/BDoryan/cbsc-back-end.git
cd cbsc-back-end
```

### 2. Install PHP dependencies

```bash
composer install
```

### 3. Install Node.js dependencies

```bash
npm install
```

### 4. Copy environment file

```bash
cp .env.example .env
```

### 5. Generate application key

```bash
php artisan key:generate
```

### 6. Configure the database (see Configuration section)

### 7. Run migrations

```bash
php artisan migrate
```

## Configuration

### Environment variables (`.env`)

```bash
APP_NAME=CBSC
APP_ENV=local
APP_KEY=
APP_DEBUG=true
APP_URL=http://localhost:8000

# Database
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=cbsc
DB_USERNAME=root
DB_PASSWORD=

# Mail
MAIL_MAILER=smtp
MAIL_HOST=smtp.mailtrap.io
MAIL_PORT=2525
MAIL_USERNAME=
MAIL_PASSWORD=
MAIL_FROM_NAME="${APP_NAME}"

# Web Push
WEBPUSH_PUBLIC_KEY=
WEBPUSH_PRIVATE_KEY=

# Other
CORS_ALLOWED_ORIGINS=*
SANCTUM_STATEFUL_DOMAINS=localhost:3000,127.0.0.1:3000
```

### CORS Configuration

Edit `config/cors.php` to allow your frontend origins.

## Getting Started

### Development mode

```bash
php artisan serve
npm run dev
```

### Production mode

```bash
npm run production
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

## API Documentation

### Base URL

```
http://localhost:8000/api
```

### Authentication

All endpoints (except `/users/login`) require a Sanctum token:

```
Authorization: Bearer {token}
```

### Main Endpoints

#### Users

| Method | Endpoint                     | Description      | Role          |
| ------ | ---------------------------- | ---------------- | ------------- |
| POST   | `/user/login`                | Login            | Public        |
| GET    | `/user/me`                   | Get current user | Authenticated |
| POST   | `/user/logout`               | Logout           | Authenticated |
| GET    | `/users`                     | Paginated users  | Authenticated |
| GET    | `/users/all`                 | All users        | Authenticated |
| GET    | `/users/licensed`            | Licensed members | Authenticated |
| GET    | `/users/managing`            | Managers         | Authenticated |
| GET    | `/users/search`              | Search users     | Authenticated |
| GET    | `/users/{id}`                | User details     | Authenticated |
| POST   | `/users`                     | Create user      | Manager       |
| PUT    | `/users/{id}`                | Update user      | Manager       |
| DELETE | `/users/{id}`                | Delete user      | Manager       |
| GET    | `/users/{id}/generate/token` | Generate token   | Manager       |

#### Convocations

| Method | Endpoint                     | Description       | Role          |
| ------ | ---------------------------- | ----------------- | ------------- |
| GET    | `/convocations`              | List convocations | Authenticated |
| GET    | `/me/convocations`           | My convocations   | Authenticated |
| GET    | `/convocations/{id}`         | Details           | Authenticated |
| GET    | `/convocations/search`       | Search            | Authenticated |
| POST   | `/convocations`              | Create            | Manager       |
| PUT    | `/convocations/{id}`         | Update            | Manager       |
| DELETE | `/convocations/{id}`         | Delete            | Manager       |
| POST   | `/convocations/{id}/accept`  | Accept            | Authenticated |
| POST   | `/convocations/{id}/decline` | Decline           | Authenticated |

#### Notifications

| Method | Endpoint             | Description       |
| ------ | -------------------- | ----------------- |
| POST   | `/subscribe`         | Subscribe to push |
| POST   | `/unsubscribe`       | Unsubscribe       |
| GET    | `/notification/test` | Test notification |

## Architecture

### Data Models

* **User**: authentication and profile
* **Convocation**: event with title, content, date
* **ConvocationInvitation**: invitation with status (pending, accepted, declined)
* **LicensedUser / ManagingUser**: role distinction

### Controllers

* `UserController`
* `UserAuthController`
* `ConvocationController`
* `SubscriptionController`

### Middlewares

* `auth:sanctum`
* `managing`
* CORS

## Database

### Main Tables

* `users`
* `convocations`
* `convocation_invitations`
* `licensed_users`
* `managing_users`
* `personal_access_tokens`

### Migrations

```bash
php artisan migrate
php artisan migrate:rollback
php artisan migrate:refresh
php artisan db:seed
```

## Authentication

### Sanctum Token

```php
Route::middleware('auth:sanctum')->group(function () {
    // Protected routes
});
```

### Role Middleware

```php
Route::middleware('managing')->group(function () {
    // Manager-only routes
});
```

### Token generation

```bash
php artisan tinker
```

## Notifications

### Web Push

Generate keys:

```bash
php artisan webpush:vapid
```

Send notification:

```php
$user->notify(new ConvocationInvitationNotification($convocation));
```

## Tests

```bash
php artisan test
php artisan test --type=unit
php artisan test --coverage
```

## Deployment

### Production setup

```bash
php artisan optimize
php artisan config:cache
php artisan route:cache
php artisan view:cache
npm run production
php artisan migrate --force
```

### HTTPS requirement

```bash
certbot certonly --standalone -d your-domain.com
```

### Production environment

```bash
APP_DEBUG=false
APP_ENV=production
SANCTUM_STATEFUL_DOMAINS=your-domain.com
CORS_ALLOWED_ORIGINS=https://your-domain.com
```
