# Utiliser l'image PHP avec FPM
FROM php:8.1-fpm

# Installer les dépendances système et les extensions PHP nécessaires
RUN apt-get update && \
    apt-get install -y libpng-dev libjpeg-dev libfreetype6-dev libzip-dev libonig-dev git unzip \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd zip pdo pdo_mysql \
    && rm -rf /var/lib/apt/lists/*

# Définir le répertoire de travail
WORKDIR /var/www/html

# Copier les fichiers de l'application dans le conteneur
COPY . .

# Installer Composer
RUN curl -sS https://getcomposer.org/installer | php \
    && mv composer.phar /usr/local/bin/composer \
    && composer install --no-dev --optimize-autoloader

# Modifier les permissions
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Exposer le port 80
EXPOSE 80

# Commande pour démarrer PHP-FPM
CMD ["php-fpm"]
