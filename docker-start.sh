#!/usr/bin/env bash

# Create storage link if not present
php artisan storage:link --force || true

# Clear previous caches
php artisan config:clear || true
php artisan route:clear || true
php artisan view:clear || true

# Attempt database migration and seeding
echo "==> Running Database Migrations..."
php artisan migrate --force || echo "==> WARNING: Database migration failed. Check DB_HOST or DATABASE_URL in Render Environment Variables."

echo "==> Running Database Seeders..."
php artisan db:seed --force || echo "==> WARNING: Database seeding failed or skipped."

# Cache configurations for production performance
php artisan config:cache || true
php artisan route:cache || true
php artisan view:cache || true

# Start Apache in foreground
echo "==> Starting Apache Web Server..."
exec apache2-foreground
