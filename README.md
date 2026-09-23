<p align="center">
	<img src="resources/images/Logo-SWCA-2025.png" alt="SWCA Timer logo" width="420">
</p>

<h1 align="center">SWCA Timer</h1>

<p align="center">
	<img src="https://img.shields.io/badge/PHP-8.2%2B-777BB4?logo=php&logoColor=white" alt="PHP 8.2+">
	<img src="https://img.shields.io/badge/Laravel-12-FF2D20?logo=laravel&logoColor=white" alt="Laravel 12">
	<img src="https://img.shields.io/badge/Vite-7-646CFF?logo=vite&logoColor=white" alt="Vite 7">
	<img src="https://img.shields.io/badge/License-MIT-22C55E" alt="MIT License">
</p>

## Setup de deploiement (Laravel)
Prerequis : PHP 8.2+, Composer, Node.js (pour les assets), et une base de données compatible (ex: MySQL).

1. Installer les dependances :
```bash
composer install --no-dev --optimize-autoloader
npm install
npm run build
```

2. Configurer l'environnement :
```bash
cp .env.example .env
php artisan key:generate
```

3. Variables d'env minimales (exemple) :
```env
APP_NAME="SWCA Timer"
APP_ENV=production
APP_KEY=base64:... # généré par php artisan key:generate
APP_DEBUG=false
APP_URL=

DB_URL=mysql://user:password@address:3306/database # connection string Mysql 
```

## Lancement avec Docker

Prerequis : Docker et Docker Compose.

1. Construire et demarrer l'application :
```bash
docker compose up --build
```

2. Ouvrir l'application :
```text
http://localhost:8000
```

Docker lance deux services :
- `app` : Laravel avec les assets Vite deja compiles dans l'image.
- `mysql` : base MySQL 8.4 persistante via le volume `mysql_data`.

Les migrations sont lancees automatiquement au demarrage du conteneur `app`.
Les variables peuvent etre surchargees depuis un fichier `.env` local, par exemple :

```env
APP_PORT=8000
DB_DATABASE=swca_timer
DB_USERNAME=swca
DB_PASSWORD=secret
DB_ROOT_PASSWORD=root
RUN_MIGRATIONS=true
```

Commandes utiles :
```bash
docker compose exec app php artisan migrate
docker compose exec app php artisan test
docker compose down
docker compose down -v # supprime aussi les donnees MySQL
```

## Guide d'utilisation

### La page Timer

**URL** : `/`

Il s'agit de la page principale pour afficher le compte à rebours. Elle est conçue pour être projetée ou diffusée pendant l'évènement. Le timer affiché est synchronisé à intervalle régulier avec le serveur. Une latence de quelques secondes peut être observée lors du démarrage ou en cas de rechargement de la page.

### La page de contrôle

**URL** : `/controls`

Depuis cette page, l'opérateur peut démarrer, arrêter ou réinitialiser le timer. Il est également possible de définir la durée du compte à rebours avant de le démarrer. Les actions effectuées ici sont reflétées sur l'ensemble des pages Timer.
