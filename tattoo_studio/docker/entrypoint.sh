#!/bin/bash
set -e

echo "Starting Ink Studio application setup..."

# Copy .env.docker or .env.example to .env if .env does not exist
if [ ! -f .env ]; then
    if [ -f .env.docker ]; then
        echo "Creating .env from .env.docker..."
        cp .env.docker .env
    elif [ -f .env.example ]; then
        echo "Creating .env from .env.example..."
        cp .env.example .env
    fi
fi

# Ensure Docker DB settings in .env
if [ -f .env ]; then
    sed -i 's/^DB_HOST=.*/DB_HOST=db/' .env 2>/dev/null || true
    sed -i 's/^DB_PORT=.*/DB_PORT=3306/' .env 2>/dev/null || true
    sed -i 's/^DB_DATABASE=.*/DB_DATABASE=tattoo_studio/' .env 2>/dev/null || true
    sed -i 's/^DB_USERNAME=.*/DB_USERNAME=tattoo_user/' .env 2>/dev/null || true
    sed -i 's/^DB_PASSWORD=.*/DB_PASSWORD=tattoo_password/' .env 2>/dev/null || true
fi

# Set permissions for storage and bootstrap/cache
echo "Setting folder permissions..."
mkdir -p storage/framework/{sessions,views,cache} storage/logs bootstrap/cache
chmod -R 777 storage bootstrap/cache 2>/dev/null || true

# Install composer dependencies if missing
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Generate application key if not set
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY= " .env || ! grep -q "APP_KEY=" .env; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# Create storage symlink
echo "Linking storage..."
php artisan storage:link --force 2>/dev/null || true

# Wait for MySQL to be ready and accepting connections
echo "Waiting for MySQL database connection at db:3306..."
max_attempts=30
attempt=0
until php -r "try { new PDO('mysql:host='.getenv('DB_HOST').';port='.getenv('DB_PORT').';dbname='.getenv('DB_DATABASE'), getenv('DB_USERNAME'), getenv('DB_PASSWORD')); exit(0); } catch(\Exception \$e) { exit(1); }" 2>/dev/null; do
    attempt=$((attempt+1))
    if [ $attempt -ge $max_attempts ]; then
        echo "Warning: Database connection check timed out after $max_attempts attempts. Proceeding with migration attempt..."
        break
    fi
    echo "Waiting for database container ($attempt/$max_attempts)..."
    sleep 2
done

echo "Database is reachable!"

# Build frontend assets if manifest.json is missing
if [ ! -f "public/build/manifest.json" ]; then
    echo "Building frontend assets..."
    npm run build 2>/dev/null || true
fi

# Run database migrations and seeders
echo "Running database migrations..."
php artisan migrate --force 2>/dev/null || true

# Run seeders if database has not been seeded yet
echo "Checking seeders..."
php artisan db:seed --force 2>/dev/null || true

echo "Ink Studio is ready!"

# Execute container command
exec "$@"
