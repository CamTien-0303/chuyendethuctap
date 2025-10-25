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