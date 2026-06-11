FROM php:8.3-apache

# Habilita mod_rewrite para o Laravel
RUN a2enmod rewrite

# Instala extensões PHP necessárias
RUN apt-get update && apt-get install -y \
    libpng-dev libjpeg-dev libwebp-dev libzip-dev libicu-dev libonig-dev \
    libxml2-dev zip unzip git curl \
  && docker-php-ext-configure gd --with-jpeg --with-webp \
  && docker-php-ext-install pdo pdo_mysql mbstring xml bcmath zip gd intl \
  && rm -rf /var/lib/apt/lists/*

# Instala o Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copia o projeto para dentro do container
WORKDIR /var/www/html
COPY . .

# Instala dependências PHP (sem dev)
RUN composer install --no-dev --optimize-autoloader

# Permissões corretas para storage e cache
RUN chown -R www-data:www-data storage bootstrap/cache \
  && chmod -R 775 storage bootstrap/cache

# Copia a config do Apache
COPY .docker/apache/000-default.conf /etc/apache2/sites-available/000-default.conf
