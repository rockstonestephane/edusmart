# Utilisation de l'image officielle PHP 8.4 avec Apache
FROM php:8.4-apache

# 1. Installation des dépendances système (librairies pour les images, le zip, etc.)
RUN apt-get update && apt-get install -y \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    zip \
    git \
    unzip \
    libzip-dev \
    libicu-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install gd pdo pdo_mysql bcmath zip intl

# 2. Activation du mod_rewrite d'Apache (essentiel pour les routes Laravel)
RUN a2enmod rewrite

# 3. Définition du répertoire de travail dans le conteneur
WORKDIR /var/www/html

# 4. Copie de tous les fichiers du projet dans le conteneur
COPY . .

# 5. Installation de Composer (outil de gestion de dépendances PHP)
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Installation des dépendances PHP sans les bibliothèques de dev (pour alléger l'image)
RUN composer install --no-dev --optimize-autoloader --no-scripts

# 7. Gestion des permissions pour les dossiers de stockage et de cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache \
    && chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# 8. On dit à Apache que le site se trouve dans le dossier /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 9. Exposition du port 80 pour le trafic web
EXPOSE 80

# 10. Lancement d'Apache au démarrage du conteneur
CMD ["apache2-foreground"]