#!/bin/bash

# Debug information
echo "Starting Laravel application..."
echo "PORT: ${PORT:-8000}"
echo "APP_ENV: ${APP_ENV:-production}"
echo "APP_DEBUG: ${APP_DEBUG:-false}"

# Check if .env exists
if [ ! -f .env ]; then
    echo "ERROR: .env file not found!"
    exit 1
fi

# Check database connection
echo "Testing database connection..."
php -r "try { DB::connection()->getPdo(); echo 'Database connected successfully\n'; } catch (Exception \$e) { echo 'Database connection failed: ' . \$e->getMessage() . '\n'; }"

# Start the application with better error handling
echo "Starting Laravel server on port ${PORT:-8000}..."
exec php -S 0.0.0.0:${PORT:-8000} -t public