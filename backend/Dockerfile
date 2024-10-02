FROM php:8.2-fpm

# Instalar dependências do sistema
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    zip \
    unzip \
    git \
    curl \
    libpq-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_pgsql

# Instalar Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

COPY . .

# Instalar as dependências do Laravel
RUN composer install

# Ajustar permissões
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage

CMD php artisan serve --host=0.0.0.0 --port=9000
EXPOSE 9000

