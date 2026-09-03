#!/usr/bin/env bash
# exit on error
set -o errexit

composer install --no-dev --optimize-autoloader

# Install node dependencies and build assets
npm install
npm run build

# Run database migrations (Optional: use --force for production)
# php artisan migrate --force
