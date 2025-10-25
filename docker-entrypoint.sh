#!/bin/bash
set -e

echo "🚀 Starting Laravel deployment..."

# Railway environment variables take precedence over .env file
if [ ! -f .env ]; then
    if [ -f .env.production ]; then
        cp .env.production .env
    else
        cp .env.example .env
    fi
    sed -i 's/APP_ENV=local/APP_ENV=production/' .env 2>/dev/null || true
    sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env 2>/dev/null || true
    sed -i 's/LOG_LEVEL=debug/LOG_LEVEL=error/' .env 2>/dev/null || true
fi

# Check APP_KEY
if [ -z "$APP_KEY" ]; then
    php artisan key:generate --force --no-interaction --ansi
    if [ -f .env ]; then
        APP_KEY_VALUE=$(grep "^APP_KEY=" .env | sed 's/^APP_KEY=//')
        if [ ! -z "$APP_KEY_VALUE" ]; then
            export APP_KEY="$APP_KEY_VALUE"
        fi
    fi
fi

# Extract individual DB variables from DATABASE_URL if needed
if [ ! -z "$DATABASE_URL" ] && [ -z "$DB_HOST" ]; then
    export DB_CONNECTION="mysql"
    export DB_HOST=$(echo $DATABASE_URL | sed 's/.*@\([^:]*\):.*/\1/')
    export DB_PORT=$(echo $DATABASE_URL | sed 's/.*:\([0-9]*\)\/.*/\1/')
    export DB_DATABASE=$(echo $DATABASE_URL | sed 's/.*\/\([^?]*\).*/\1/')
    export DB_USERNAME=$(echo $DATABASE_URL | sed 's/.*:\/\/\([^:]*\):.*/\1/')
    export DB_PASSWORD=$(echo $DATABASE_URL | sed 's/.*:\/\/[^:]*:\([^@]*\)@.*/\1/')
fi

# Wait for database
wait_for_db() {
    timeout=30
    counter=0

    while [ $counter -lt $timeout ]; do
        if [ ! -z "$DB_HOST" ] && [ ! -z "$DB_PASSWORD" ]; then
            if php -r "
                try {
                    \$pdo = new PDO('mysql:host=${DB_HOST};port=${DB_PORT:-3306};dbname=${DB_DATABASE}', '${DB_USERNAME}', '${DB_PASSWORD}', [
                        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
                    ]);
                    \$pdo->query('SELECT 1');
                    exit(0);
                } catch (Exception \$e) {
                    exit(1);
                }
            " 2>/dev/null; then
                echo "✅ Database ready"
                return 0
            fi
        fi

        sleep 2
        counter=$((counter + 2))
    done

    echo "⚠️ Database timeout, continuing anyway..."
    return 0
}

wait_for_db

# Run migrations
if [ ! -z "$DB_HOST" ] || [ ! -z "$DATABASE_URL" ]; then
    echo "🗄️ Running migrations..."
    php artisan migrate --force --no-interaction || true
    php artisan db:seed --force --no-interaction || true
fi

# Laravel optimizations
echo "⚡ Optimizing Laravel..."
php artisan config:clear --no-interaction || true
php artisan cache:clear --no-interaction || true
php artisan view:clear --no-interaction || true
php artisan route:clear --no-interaction || true

php artisan config:cache --no-interaction || true
php artisan route:cache --no-interaction || true
php artisan view:cache --no-interaction || true
php artisan optimize --no-interaction || true

# Create storage link
if [ ! -L "public/storage" ]; then
    php artisan storage:link --no-interaction || true
fi

# Set permissions
chown -R www-data:www-data /var/www/html
chmod -R 755 /var/www/html
chmod -R 775 storage bootstrap/cache

echo "🎉 Laravel ready!"

# Configure Apache PORT for Railway
if [ ! -z "$PORT" ]; then
    echo "Listen $PORT" > /etc/apache2/ports.conf
    sed -i "s/<VirtualHost \*:80>/<VirtualHost *:$PORT>/" /etc/apache2/sites-available/000-default.conf
fi

echo "🌐 Starting Apache..."
exec apache2-foreground
