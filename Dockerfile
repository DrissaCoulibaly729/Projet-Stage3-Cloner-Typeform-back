# Utilisez une image PHP de base
FROM php:8.1-fpm

# Installez les extensions PHP nécessaires
RUN apt-get update && apt-get install -y \
    libssl-dev \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd

# Copiez votre application PHP dans le conteneur
COPY . /var/www/html

# Définir le répertoire de travail
WORKDIR /var/www/html

# Expose le port 80 pour accéder à l'application
EXPOSE 80

# Démarrer le serveur PHP
CMD ["php-fpm"]
