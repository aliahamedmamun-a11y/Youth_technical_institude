#!/usr/bin/env bash
# exit on error
set -o errexit

# Install PHP dependencies
composer install --no-dev --optimize-autoloader

# Install Node dependencies and build assets
npm install
npm run build

# Clear any existing cache
php artisan optimize:clear

# Run migrations safely if database connection is available
php artisan migrate --force || echo "Migrations skipped during build phase"
