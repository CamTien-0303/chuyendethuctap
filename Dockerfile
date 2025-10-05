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
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 7. Copy package files và cài npm dependencies (bao gồm dev dependencies để build)
COPY package.json package-lock.json ./
RUN npm install

# 8. Copy source code
COPY . .

# 9. Build assets và optimize
RUN npx vite --version
RUN npm run build
RUN php artisan config:cache && php artisan route:cache

# 10. Tạo storage directories và set permissions
RUN mkdir -p storage/logs storage/framework/cache storage/framework/sessions storage/framework/views \
    && chmod -R 775 storage bootstrap/cache

# 11. Expose port
EXPOSE 8000

# 12. Start command
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]
