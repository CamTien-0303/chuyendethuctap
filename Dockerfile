<<<<<<< HEAD
FROM php:8.2-apache

# Install system dependencies including Node.js
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    nodejs \
    npm \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql zip \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Enable Apache mod_rewrite and set ServerName
RUN a2enmod rewrite && \
    echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Set working directory
WORKDIR /var/www/html

# Copy composer files first (for better layer caching)
COPY composer.json composer.lock ./

# Install PHP dependencies
RUN composer install --no-dev --no-scripts --no-autoloader

# Copy package.json for Node.js dependencies
COPY package.json package-lock.json* ./

# Install Node.js dependencies (including dev dependencies for build)
RUN npm ci

# Copy application files
COPY . .

# Build frontend assets
RUN npm run build

# Clean up dev dependencies to reduce image size (optional)
RUN npm ci --only=production && npm cache clean --force

# Create production .env if needed (will be overridden by Railway env vars)
RUN if [ ! -f .env ]; then \
    if [ -f .env.production ]; then \
    cp .env.production .env; \
    else \
    cp .env.example .env; \
    fi \
    fi

# Complete composer setup
RUN composer dump-autoload --optimize --no-dev

# Set permissions
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html \
    && chmod -R 775 storage bootstrap/cache

# Copy and setup entrypoint
COPY docker-entrypoint.sh /usr/local/bin/
RUN chmod +x /usr/local/bin/docker-entrypoint.sh

# Copy Apache config
COPY .htaccess /var/www/html/.htaccess

# Health check - use PORT variable if available
HEALTHCHECK --interval=30s --timeout=10s --start-period=120s --retries=3 \
    CMD curl -f http://localhost:${PORT:-80}/health || exit 1

# Expose port 80 by default, Railway will override with PORT variable
EXPOSE 80

ENTRYPOINT ["docker-entrypoint.sh"]
=======
# 1. Base image PHP + extensions cần cho Laravel
FROM php:8.2-cli

# 2. Cài các thư viện hệ thống và PHP extensions
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl \
    libzip-dev libfreetype6-dev libjpeg62-turbo-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd zip

# 3. Cài Node.js và npm
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# 4. Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 5. Tạo working directory
WORKDIR /var/www/html

# 6. Copy composer files trước để tận dụng cache layer
COPY composer.json composer.lock ./
RUN composer install --optimize-autoloader --no-scripts

# 7. Copy package files và cài npm dependencies (bao gồm dev dependencies để build)
COPY package.json package-lock.json ./
RUN npm install

# 8. Copy source code
COPY . .

# 9. Build assets và optimize
RUN npx vite --version
RUN npm run build

# 10. Tạo storage directories và set permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 storage bootstrap/cache

# 11. Tạo .env file với database config
RUN echo "APP_NAME=Laravel" > .env \
    && echo "APP_ENV=production" >> .env \
    && echo "APP_KEY=" >> .env \
    && echo "APP_DEBUG=false" >> .env \
    && echo "APP_URL=https://shop-flower-sell.onrender.com" >> .env \
    && echo "DB_CONNECTION=mysql" >> .env \
    && echo "DB_HOST=switchback.proxy.rlwy.net" >> .env \
    && echo "DB_PORT=54387" >> .env \
    && echo "DB_DATABASE=railway" >> .env \
    && echo "DB_USERNAME=root" >> .env \
    && echo "DB_PASSWORD=mXIKnFWVTfFwKDETthuwftSnoNhEXxlO" >> .env \
    && echo "CACHE_DRIVER=file" >> .env \
    && echo "SESSION_DRIVER=file" >> .env \
    && echo "QUEUE_CONNECTION=sync" >> .env

# 12. Tạo APP_KEY và chạy migrations
RUN php artisan key:generate --force
RUN php artisan migrate --force
# Đảm bảo Faker được load trước khi seed
RUN composer dump-autoload
RUN php artisan db:seed --force
RUN php artisan storage:link
RUN php artisan config:cache && php artisan route:cache

# 13. Expose port
EXPOSE 8000

# 14. Start command
COPY start.sh /start.sh
RUN chmod +x /start.sh
CMD ["/start.sh"]
>>>>>>> b8142234838c82bb5657a2d94c196291b8e6f389
