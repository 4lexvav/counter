FROM php:7.2.30-apache

RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer

# Change apache site config
COPY docker/apache/default.conf /etc/apache2/sites-available/000-default.conf

WORKDIR /var/www/html/

RUN rm -rf /var/www/html/*
COPY counter/ /var/www/html/

RUN composer install --no-dev --prefer-dist --optimize-autoloader && \
    composer clear-cache

# Set www as owner
RUN chown -R www-data:www-data /var/www && a2enmod rewrite

EXPOSE 80