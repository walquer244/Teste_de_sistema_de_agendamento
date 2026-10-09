#!/bin/bash

# Wait for MySQL database to be ready
echo "Waiting for MySQL database connection..."
until nc -z -v -w30 db 3306; do
  echo "Waiting for database container..."
  sleep 2
done

echo "MySQL database is ready!"

# Copy .env.example to .env if .env does not exist
if [ ! -f .env ]; then
    echo "Creating .env file from .env.example..."
    cp .env.example .env
fi

# Set permissions for storage and cache directories
chmod -R 777 storage bootstrap/cache

# Install composer dependencies if vendor directory is missing
if [ ! -d "vendor" ]; then
    echo "Installing Composer dependencies..."
    composer install --no-interaction --prefer-dist --optimize-autoloader
fi

# Generate application key if not set
if grep -q "APP_KEY=$" .env || grep -q "APP_KEY= " .env || ! grep -q "APP_KEY=" .env; then
    echo "Generating Application Key..."
    php artisan key:generate --force
fi

# Create storage link if not present
echo "Linking storage..."
php artisan storage:link --force || true

# Run database migrations
echo "Running database migrations..."
php artisan migrate --force

echo "Application is ready!"

# Execute container command
exec "$@"
