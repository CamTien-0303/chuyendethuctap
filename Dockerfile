# 1. Base image PHP + extensions cần cho Laravel
FROM php:8.2-apache

# 2. Cài các thư viện hệ thống
RUN apt-get update && apt-get install -y \
    git unzip libpng-dev libonig-dev libxml2-dev zip curl npm

# 3. Cài composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# 4. Sao chép toàn bộ code vào container
WORKDIR /var/www/html
COPY . .

# 5. Cài Laravel dependencies
RUN composer install --no-dev --optimize-autoloader
RUN npm install && npm run build

# 6. Tạo key và cache
RUN php artisan key:generate
RUN php artisan config:cache && php artisan route:cache && php artisan view:cache

# 7. Cho phép ghi file
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# 8. Mở cổng 8000 và chạy Laravel serve
EXPOSE 8000
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=8000"]