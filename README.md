# WattLoc

WattLoc is a Laravel web application for renting temporary energy equipment
in Tunisia. Users can browse products and ready-to-rent energy packs, use the
energy calculator, and submit a reservation or contact request. An
administrator can manage products, packs, reservations, availability, and
application settings.

## Technology stack

- PHP 8.1 or newer
- Laravel 10
- MySQL 8
- Node.js 20 or newer and Vite
- Docker Desktop (optional, recommended for the easiest setup)

## Requirements

Choose **one** of the following setup methods:

### Docker setup

- Docker Desktop with Docker Compose
- Git

### Local setup

- PHP 8.1+
- Composer 2
- Node.js 20+ and npm
- MySQL 8+
- Git

PHP must have the extensions required by Laravel and this project, including
`pdo_mysql`, `mbstring`, `openssl`, `bcmath`, `fileinfo`, `xml`, `ctype`,
`json`, and `tokenizer`.

## Installation with Docker (recommended)

1. Clone the repository and enter its directory:

   ```bash
   git clone https://github.com/CactusSenpa/projet_laravel.git
   cd projet_laravel
   ```

2. Start the application, MySQL, phpMyAdmin, and Mailpit:

   ```bash
   docker compose up --build -d
   ```

3. Create the database tables and load the demo products, packs, appliances,
   settings, and administrator account:

   ```bash
   docker compose exec app php artisan migrate --seed
   ```

4. Open the application:

   - Application: <http://localhost:8000>
   - phpMyAdmin: <http://localhost:8080>
   - Mailpit: <http://localhost:8025>

   The default phpMyAdmin connection is:

   | Setting | Value |
   | --- | --- |
   | Server | `mysql` |
   | Username | `laravel` |
   | Password | `laravel` |

The Docker Compose configuration exposes MySQL on port `3307` on the host.
The application itself connects to the MySQL container using the service name
`mysql`.

### Docker configuration

The defaults work without an `.env` file. To customize them, create or edit
`.env` in the project root:

```dotenv
APP_NAME=WattLoc
APP_URL=http://localhost:8000
DOCKER_DB_DATABASE=laravel
DOCKER_DB_USERNAME=laravel
DOCKER_DB_PASSWORD=laravel
DOCKER_DB_ROOT_PASSWORD=root
```

Do not use these default passwords in a production deployment.

Useful Docker commands:

```bash
# Follow application logs
docker compose logs -f app

# Run an Artisan command
docker compose exec app php artisan <command>

# Stop the services and keep the database volume
docker compose down

# Stop the services and delete the database volume
docker compose down -v
```

After PHP or frontend source changes, rebuild the application image:

```bash
docker compose up --build -d
```

## Local installation without Docker

1. Clone the repository:

   ```bash
   git clone https://github.com/CactusSenpa/projet_laravel.git
   cd projet_laravel
   ```

2. Install PHP dependencies:

   ```bash
   composer install
   ```

3. Install frontend dependencies:

   ```bash
   npm install
   ```

4. Create the environment file and generate the application key:

   ```bash
   cp .env.example .env
   php artisan key:generate
   ```

   On Windows PowerShell, use this instead of `cp`:

   ```powershell
   Copy-Item .env.example .env
   ```

5. Create a MySQL database, then update the database values in `.env`:

   ```dotenv
   DB_CONNECTION=mysql
   DB_HOST=127.0.0.1
   DB_PORT=3306
   DB_DATABASE=laravel
   DB_USERNAME=root
   DB_PASSWORD=your_mysql_password
   ```

   For example, in MySQL:

   ```sql
   CREATE DATABASE laravel CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
   ```

6. Run the migrations and seed the demo data:

   ```bash
   php artisan migrate --seed
   ```

7. Create the public storage link:

   ```bash
   php artisan storage:link
   ```

8. Build the frontend assets:

   ```bash
   npm run build
   ```

9. Start the Laravel development server:

   ```bash
   php artisan serve
   ```

   The application is available at <http://127.0.0.1:8000>.

For frontend development with Vite hot reload, keep the Laravel server
running in one terminal and run this command in another:

```bash
npm run dev
```

## Demo administrator account

The database seeder creates the following local development account:

```text
Email:    admin@wattloc.test
Password: aazze
```

The administrator area is available at
<http://127.0.0.1:8000/login>, then under `/admin`. Change or remove this
development credential before deploying the application.

## Main application pages

- `/` - Home page
- `/catalogue` - Product catalogue
- `/packs` - Energy packs
- `/calculator` - Energy needs calculator
- `/reservation` - Reservation request form
- `/faq` - Frequently asked questions
- `/conditions` - Terms and conditions
- `/contact` - Contact form
- `/login` - Administrator login
- `/admin` - Administrator dashboard

## Tests and code quality

Run the Laravel test suite:

```bash
php artisan test
```

Run the Laravel code formatter:

```bash
vendor/bin/pint
```

Build the production frontend bundle:

```bash
npm run build
```

## Common troubleshooting

### The application key is missing

Run:

```bash
php artisan key:generate
```

For Docker, set `APP_KEY` in `.env` or run:

```bash
docker compose exec app php artisan key:generate
```

### Database connection errors

Check that MySQL is running and that the `DB_*` values in `.env` are correct.
When using Docker, the database host must be `mysql` from inside the
application container; do not replace it with `127.0.0.1`.

### Frontend assets are missing

Install dependencies and rebuild the assets:

```bash
npm install
npm run build
```

### Uploaded images are not visible

Run:

```bash
php artisan storage:link
```

For Docker, run:

```bash
docker compose exec app php artisan storage:link
```

## Project structure

```text
app/                 Application code, models, controllers, and helpers
database/            Migrations, factories, and seeders
public/              Public entry point and compiled assets
resources/views/     Blade templates
resources/js/        Frontend JavaScript
resources/css/       Frontend styles
routes/              Web and API routes
docker/              Docker entrypoint scripts
Dockerfile           Production-style application image
docker-compose.yml   Local Docker development services
```

## License

This project is provided for educational and development use. Add the
project's official license here if one is selected.
